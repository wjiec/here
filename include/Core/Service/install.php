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

                Common::recordSet('_config_', base64_encode(serialize($dbConfig)), time() + 1440); // 24min
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

        $option = Request::r('option');
        if ($option != null) {
            self::dbExists($option, $dbConfig);
        } else {
            $option = Request::rs('title', 'username', 'password', 'email');
            $option = array_filter($option);
            self::newUser($option, $dbConfig);
            self::initOption(Request::r('title'));

            echo Common::toJSON([
                'fail' => 0,
                'data' => 'addUser Complete'
            ]);
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
                self::eraseData($dbConfig);

                Request::s('step', 3, Request::REST);
                Service::install('step');
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

    private static function eraseData($dbConfig) {
        define('_REASE_', true);
        Response::header('JAX-Container', '#here-replace-container');
        $scripts = "TRUNCATE here_classify|TRUNCATE here_comments|TRUNCATE here_options|TRUNCATE here_posts|TRUNCATE here_users";

        $scripts = str_replace('here_', $dbConfig['prefix'], $scripts);
        $scripts = explode('|', $scripts);

        $truncateDb = Db::factory(Db::CONNECT);
        foreach ($scripts as $script) {
            $truncateDb->query($script);
        }
    }

    private static function newUser($options, $dbConfig) {
        $time = time();
        $password = self::pawdencrypt($options['password'], $time);

        try {
            if (count($options) != 4) {
                throw new Exception('Fatal Error. POST Data cannot match', 9);
            }

            $userDb = new Db();
            $userDb->query($userDb->insert('table.users')->rows([
                'name' => $options['username'],
                'password' => $password,
                'email' => $options['email'],
                'created' => $time,
                'lastlogin' => $time
            ]));

            $siteInfo = [
                'username' => $options['username'],
                'email' => $options['email'],
                'title' => $options['title']
            ];
            Common::sessionSet('_info_', serialize($siteInfo));
            self::writeConf($dbConfig, $siteInfo);
        } catch (Exception $e) {
            echo Common::toJSON([
                'fail' => 1,
                'data' => "{$e->getCode()}: {$e->getMessage()}"
            ]);
        }
    }

    private static function initOption($title) {
        try {
            $insertDb = new Db();
            $insertDb->query($insertDb->insert('table.options')->keys(array('name', 'value'))->values(
                array('title', $title),
                array('theme', 'default'),
                array('activePlugins', serialize(array(
                    'HelloWorld_Plugin' => array(
                        Plugins_Manage::PLUGIN_HOOKS      => array('index@header' => array('HelloWorld_Plugin', 'render')),
                        Plugins_Manage::PLUGIN_STATUS     => Plugins_Manage::PLUGIN_SS_ACTIVE
                    )
                )))
            ));
        } catch (Exception $e) {
            ob_clean();
            echo Common::toJSON([
                'fail' => 1,
                'data' => "{$e->getCode()}: {$e->getMessage()}"
            ]);
        }
    }

    private static function pawdencrypt($password, $time) {
        if (function_exists('password_hash') && function_exists('password_verify')) {
            return password_hash($password, PASSWORD_DEFAULT);
        } else {
            return Common::pawdEncrypt($password, $time);
        }
    }

    private static function writeConf($dbConfig, $site) {
        $dbConfig = array_map('addslashes', $dbConfig);
        $site = array_map('addslashes', $site);
        $bool = (function_exists('password_hash') && function_exists('password_verify')) ? 'false' : 'true';
// TODO Router configure
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
    'user'     => '{$dbConfig['user']}',
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

# Password Encrypt
Core::setUseCommon({$bool});

EOF;
        file_put_contents('config.inc.php', $config);

        Common::cookieSet('_config_', false, time() - 1);
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
        $useful = array();

        foreach ($lines as $key => $line) {
            if(!preg_match('/^--/', $line)) {
                $useful[] = $line;
            }
        }
        $string = implode("\n", $useful);
        $string = trim($string, "\n");
    }
}