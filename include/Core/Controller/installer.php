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
        self::$value = Request::r('step', Request::RESTFUL) ? Request::r('step', Request::RESTFUL) : 1;
        return self::_include('step');
    }

    public static function validate() {
        if (!get_magic_quotes_gpc()) {
            array_map(function($v) { addslashes($v); }, $_POST);
            try {
                DB::server(Request::r('host'), Request::r('user'), Request::r('password'), Request::r('database'), Request::r('port'));
                self::initTable(Request::r('database'), Request::r('prefix'));

                echo JSON::fromArray([
                    'fail' => 0,
                    'data' => 'Server version: 5.5.28 MySQL Community Server (GPL)'
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
                'data' => 'Server version: 5.5.28 MySQL Community Server (GPL)' // mysql: status or select version()
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

        foreach ($scripts as $script) {
            DB::query($script);
        }
    }

    private static function strReplace($search, $replace, &$subject) {
        $subject = str_replace($search, $replace, $subject);
    }
}