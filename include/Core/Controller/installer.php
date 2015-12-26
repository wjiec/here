<?php

class Controller_Installer {
    const SEPARATOR = ';';
    
    public static function serverDetect() {
        return true;
    }
    
    public static function failServerItemList() {
    }

    public static function step($route) {
        self::_include('step', intval(isset($_REQUEST['step']) ? $_REQUEST['step'] : 1), $route);
    }

    public static function validate($params) {
        if (!get_magic_quotes_gpc()) {
            array_map(function($v) { addslashes($v); }, $_POST);
            try {
                if ($_POST['action'] == 'db') {
                    DB::ping($_POST['db-user'], $_POST['db-pawd'], $_POST['db-name'], $_POST['db-addr'], $_POST['db-port']);
                    self::initTable($_POST['db-user'], $_POST['db-pawd'], $_POST['db-name'], $_POST['db-pref'], $_POST['db-addr'], $_POST['db-port']);
                } else if ($_POST['action'] == 'user') {
                    self::addUser($_POST['username'], $_POST['password'], $_POST['email']);
                }
                echo "{\"fail\":0,\"data\":\"\"}";
            } catch (Exception $e) {
                echo "{\"fail\":1,\"data\":\"{$e->getCode()}: {$e->getMessage()}\"}";
            }
        }
    }

    private static function _include($a, $f, $r = null) {
        if ($f > 0 && $f < 5) {
            include "install/{$a}/{$f}.php";
        } else {
            if ($r) { $r['_this']->error('404', $r); }
        }
    }

    private static function initTable($user, $password, $database, $pref, $host, $port = 3306) {
        $scripts = file_get_contents('scripts/mysql.sql', true);
        $scripts = explode(self::SEPARATOR, $scripts);
        $query = new DB($user, $password, $database, $pref, $host, $port);
        foreach ($scripts as $script) {
            $query->query($script);
        }
        unset($query);
    }

    private static function addUser($username, $password, $email) {
        
    }
}