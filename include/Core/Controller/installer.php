<?php

class Controller_Installer {
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

                // TEST
                var_dump($installDb->select()->from('table.options')
                        ->where('for', Db::OP_GT, 2)->where('for', Db::OP_GT, 2, Db::RS_AND)
                        ->group('for')->having('for', Db::OP_GT, 1)->having('for', Db::OP_GT, 1, Db::RS_OR)
                        ->order('name')->limit(3)->offset(0)->__toString());
                die();

                Common::cookieSet('_config_', base64_encode(serialize($dbConfig)));
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

    public static function addUser() {
        $dbConfig = unserialize(base64_decode(Common::cookieGet('_config_')));
        Db::server($dbConfig);

        echo Common::toJSON([
            'fail' => 0,
            'data' => 'addUser Complete'
        ]);
    }

    private static function _include($action) {
        if (include "install/{$action}.php") {
            return true;
        }
        Core::router()->error('404', 'File not found');
    }

    private static function initTable() {
        $scripts = file_get_contents('install/scripts/mysql.sql', true);

        self::filter($scripts);
        self::strReplace('here_', Request::r('prefix'), $scripts);
        $scripts = explode(self::$SEPARATOR, $scripts);

        $tableDb = Db::factory(Db::CONNECT);
        foreach ($scripts as $script) {
            $tableDb->query($script);
        }
    }

    private static function strReplace($search, $replace, &$subject) {
        $subject = str_replace($search, $replace, $subject);
    }

    private static function filter(&$string) {
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