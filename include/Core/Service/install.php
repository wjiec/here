<?php
if (!defined('_HERE_INSTALL_') && !Common::sessionGet('_install_')) {
    exit;
}

/**
 * Installer Service
 * @author ShadowMan
 * @package Here.Service Installer
 */
class Service_Install {
    private static $SEPARATOR = ';';
    private static $value = null;

    public static function serverDetect() {
        return true;
    }

    public static function failServerDetectList() {
        // <li></li>
    }

    public static function step() {
        self::$value = Request::r('step', Request::REST) ? Request::r('step', Request::REST) : 1;
        return self::_include('step');
    }

    public static function dbConfig() {
        if (!get_magic_quotes_gpc()) {
            try {
                $dbConfig = Request::rs('host', 'user', 'password', 'database', 'port', 'prefix');
                $dbConfig = array_filter($dbConfig);
                if (count($dbConfig) != 6) {
                    throw new Exception('Fatal Error. POST Data cannot match', 9);
                }
                Db::server($dbConfig);

                self::initTable();
                $installDb = Db::factory(Db::CONNECT);

                Common::recordSet('_config_', base64_encode(serialize($dbConfig)));
                echo Common::toJSON([
                    'fail' => 0,
                    'data' => 'Server version: ' . $installDb->getServerInfo() . ' MySQL Community Server (GPL)'
                ]);
            } catch (Exception $e) {
                echo Common::toJSON([
                    'fail' => 1,
                    'data' => "{$e->getCode()}: {$e->getMessage()}"
                ]);
            }
        }
    }

    private static function initTable() {
        $scripts = file_get_contents('install/scripts/mysql.sql', true);

        self::scriptFilter($scripts);
        self::strReplace('here_', Request::r('prefix'), $scripts);
        $scripts = explode(self::$SEPARATOR, $scripts);
    
        $tableDb = Db::factory(Db::CONNECT);
        foreach ($scripts as $script) {
            $tableDb->query($script);
        }
    }

    public static function userConfig() {
        $dbConfig = unserialize(base64_decode(Common::recordGet('_config_')));
        Db::server($dbConfig);

        $siteInfo = Request::rs('title', 'username', 'password', 'email');
        $option = Request::r('save');
        if ($option != null) {
            self::dbExists($option, $dbConfig);
        } else {
            $option = Request::rs('title', 'username', 'password', 'email');
            $option = array_filter($option);
            self::newOptions($option, $dbConfig);
        }
    }

    private static function dbExists($save, $dbConfig) {
        try {
            if ($save == 'YES') {
                $infoDb = new Db();
                $infoDb->query($infoDb->select('name', 'email')->from('table.users'));
                $user = $infoDb->fetchAssoc();
                $infoDb->query($infoDb->select('value')->from('table.options')->where('name', Db::OP_EQUAL, 'title'));
                $title = $infoDb->fetchAssoc();

                $siteInfo = [
                    'username' => $user['name'],
                    'email' => $user['email'],
                    'title' => $title['value']
                ];
                Common::sessionSet('_info_', serialize($siteInfo));

                self::writeConf($dbConfig, $siteInfo);
                echo Common::toJSON([
                    'fail' => 0,
                    'data' => 'Using origin Data'
                ]);
            } else if ($save == 'NO') {
    
            } else {
                throw new Exception('Fatal Error. POST Data cannot match', 9);
            }
        } catch (Exception $e) {
            echo Common::toJSON([
                'fail' => 1,
                'data' => "{$e->getCode()}: {$e->getMessage()}"
            ]);
        }
    }

    private static function newOptions($options, $dbConfig) {
        try {
            $info = Request::rs('title', 'username', 'password', 'email');
            $info = array_filter($info);

            if (count($options) != 4) {
                throw new Exception('Fatal Error. POST Data cannot match', 9);
            }

            $userDb = Db::factory(Db::NORMAL);
            $userDb->query($userDb->insert('table.users')->rows([
                'name' => $info['username'],
                'password' => $info['password'],
                'email' => $info['email'],
                'created' => time(),
                'lastlogin' => time()
            ]));

            // TODO. $db->insert()->rows()->rows()...
            $userDb->query($userDb->insert('table.options')->rows([
                'name' => 'title',
                'value' => $info['title']
            ]));
            $userDb->query($userDb->insert('table.options')->rows([
                'name' => 'theme',
                'value' => 'default'
            ]));

            $siteInfo = [
                'username' => $info['username'],
                'email' => $info['email'],
                'title' => $info['title']
            ];
            Common::sessionSet('_info_', serialize($siteInfo));
            self::writeConf($dbConfig, $siteInfo);
            echo Common::toJSON([
                'fail' => 0,
                'data' => 'addUser Complete'
            ]);
        } catch (Exception $e) {
            echo Common::toJSON([
                'fail' => 1,
                'data' => "{$e->getCode()}: {$e->getMessage()}"
            ]);
        }
    }

    private static function writeConf($dbConfig, $site) {
        $dbConfig = array_map('addslashes', $dbConfig);
        $site = array_map('addslashes', $site);

        $config = <<<EOF
<?php
/**
 * Config for Here
 * @author ShadowMan
 * @package Here Config
 */

# Database
Db::server([
    'host'     => '{$dbConfig['host']}',
    'port'     => '{$dbConfig['user']}',
    'password' => '{$dbConfig['password']}',
    'database' => '{$dbConfig['database']}',
    'port'     => '{$dbConfig['port']}',
    'prefix'   => '{$dbConfig['prefix']}'
]);

# Web Site
Theme::configSet([
    'title' => '{$site['title']}',
    'theme' => 'default'
]);
EOF;
        file_put_contents('config.php', $config);
    }

    private static function _include($action) {
        if (include "install/{$action}.php") {
            return true;
        }
        Core::router()->error('404', 'File not found');
    }

    private static function strReplace($search, $replace, &$subject) {
        $subject = str_replace($search, $replace, $subject);
    }

    private static function scriptFilter(&$string) {
        $lines = explode("\n", $string);
        $useful = [];

        foreach ($lines as $key => $line) {
            if(!preg_match('/^--/', $line)) {
                $useful[] = $line;
            }
        }
        $string = implode("\n", $useful);
        $string = trim($string, "\n");
    }
}