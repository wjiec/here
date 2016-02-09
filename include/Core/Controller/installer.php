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
        self::$value = Request::r('step') ? Request::r('step') : 1;
        return self::_include('step');
    }

    public static function validate() {
        if (!get_magic_quotes_gpc()) {
//             array_map(function($v) { addslashes($v); }, $_POST); TODO: escape, secure
            try {
                if (Request::r('action') == 'db') {
                    DB::server(Request::r('host'), Request::r('user'), Request::r('password'), Request::r('database'), Request::r('port'));
                    self::initTable(Request::r('database'), Request::r('prefix'));
                } else if (Request::r('action') == 'user') {
                    self::addUser(Request::r('username'), Request::r('password'), Request::r('email'));
                }
                echo "{\"fail\":0,\"data\":\"\"}";
            } catch (Exception $e) {
                echo "{\"fail\":1,\"data\":\"{$e->getCode()}: {$e->getMessage()}\"}";
            }
        }
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

        foreach ($scripts as $script) {
            DB::query($script);
        }
    }

    private static function addUser($username, $password, $email) {
        
    }

    private static function strReplace($search, $replace, &$subject) {
        $subject = str_replace($search, $replace, $subject);
    }
}