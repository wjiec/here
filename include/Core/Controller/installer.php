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

                # TEST
                $installDb = new Db();
                $installDb->query($installDb->insert('here_users')->rows([ 'name' => 'ShadowMan', 'password' => md5('ac.linux'), 'email' => 'shadowman@shellboot.com', 'url' => 'http://www.shellboot.com' ]));
                # TEST

                echo JSON::fromArray([
                    'fail' => 0,
                    'data' => 'Server version: ' . $installDb->getServerInfo() . ' MySQL Community Server (GPL)'
                ]);
            } catch (Exception $e) {
                echo JSON::fromArray([
                    'fail' => 1,
                    'data' => "{$e->getCode()}: {$e->getMessage()}"
                ]);
            }
        }
    }

    public static function addUser() {
        echo JSON::fromArray([
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

    private static function initTable($database, $prefix) {
        $scripts = file_get_contents('install/scripts/mysql.sql', true);
        self::strReplace('{%database%}', $database, $scripts);
        self::strReplace('{%prefix%}_', $prefix, $scripts);
        $scripts = explode(self::$SEPARATOR, $scripts);
        
    }

    private static function strReplace($search, $replace, &$subject) {
        $subject = str_replace($search, $replace, $subject);
    }
}