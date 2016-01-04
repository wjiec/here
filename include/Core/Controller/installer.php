<?php

class Controller_Installer {
    const SEPARATOR = ';';
    
    public static function serverDetect() {
        return true;
    }
    
    public static function failServerDetectList() {
    }

    public static function step($route) {
        self::_include('step', intval(isset($_REQUEST['step']) ? $_REQUEST['step'] : 1), $route);
    }

    public static function validate($params) {
        if (!get_magic_quotes_gpc()) {
//             array_map(function($v) { addslashes($v); }, $_POST); TODO
            try {
                if (Request::r('action') == 'db') {
                    DB::server(Request::r('host'), Request::r('user'), Request::r('password'), Request::r('database'), Request::r('port'));
                    self::initTable();
                } else if (Request::r('action') == 'user') {
                    self::addUser(Request::r('username'), Request::r('password'), Request::r('email'));
                }
                echo "{\"fail\":0,\"data\":\"\"}";
            } catch (Exception $e) {
                echo "{\"fail\":1,\"data\":\"{$e->getCode()}: {$e->getMessage()}\"}";
            }
        }
    }

    private static function _include($action, $file, &$router = null) {
        if ($file > 0 && $file < 5) {
            include "install/{$action}/{$file}.php";
        } else {
            if ($router) { $router['_this']->error('404', $router); }
        }
    }

    private static function initTable() {
        $scripts = file_get_contents('scripts/mysql.sql', true);
        $scripts = explode(self::SEPARATOR, $scripts);
        $query = new DB();
        foreach ($scripts as $script) {
            $query->query($script);
        }
        unset($query);
    }

    private static function addUser($username, $password, $email) {
        
    }
}