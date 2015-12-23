<?php

class Controller_Installer {
    public static function serverDetect() {
        
    }

    public static function step($route) {
        self::_include(__FUNCTION__, intval(isset($_REQUEST[__FUNCTION__]) ? $_REQUEST[__FUNCTION__] : 1), $route);
    }

    public static function validate($params) {
        if (!get_magic_quotes_gpc()) {
            foreach ($_POST as &$v) {
                if (empty($v)) { exit; }
                $v = addslashes($v);
            }
            try {
                if ($_POST['action'] == 'db') {
                    DB::connectTest($_POST['db-user'], $_POST['db-pawd'], $_POST['db-name'], $_POST['db-addr'], $_POST['db-port']);
                    DB::initTable($_POST['db-user'], $_POST['db-pawd'], $_POST['db-name'], $_POST['db-pref'], $_POST['db-addr'], $_POST['db-port']);
                } else if ($_POST['action'] == 'user') {
                    DB::addUser($_POST['username'], $_POST['password'], $_POST['email']);
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
}