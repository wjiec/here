<?php
/**
 * Installer Service
 * @author ShadowMan
 * @package Here.Service Installer
 */
class Service_Installer {
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

    public static function validate() {
        if (!get_magic_quotes_gpc()) {
            try {
                $dbConfig = Request::rs('host', 'user', 'password', 'database', 'port', 'prefix');
                $dbConfig = array_filter($dbConfig);
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

    public static function addUser() {
        $dbConfig = unserialize(base64_decode(Common::recordGet('_config_')));
        Db::server($dbConfig);

        try {
            $userDb = Db::factory(Db::CONNECT);

            $userDb->query($userDb->insert('table.users')->rows([
                'name' => Request::r('username'),
                'password' => Request::r('password'),
                'email' => Request::r('email'),
                'created' => time(),
                'lastlogin' => time()
            ]));

            $userDb->query($userDb->insert('table.options')->rows([
                'name' => 'title',
                'value' => Request::r('title')
            ]));

            $siteInfo = [
                'username' => Request::r('username'),
                'email' => Request::r('email'),
                'title' => Request::r('title')
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

    private static function writeConf($dbConfig, $info) {
        $config = <<<EOF
<?php
/**
 * Config for Here
 * @author ShadowMan
 * @package Here Config
 */

Db::server([
    'host'     => '{$dbConfig['host']}',
    'port'     => '{$dbConfig['user']}',
    'password' => '{$dbConfig['password']}',
    'database' => '{$dbConfig['database']}',
    'port'     => '{$dbConfig['port']}',
    'prefix'   => '{$dbConfig['prefix']}'
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