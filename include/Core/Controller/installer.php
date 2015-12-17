<?php

class Controller_Installer {
    public static function step($params) {
        self::_include(intval(isset($_REQUEST['step']) ? $_REQUEST['step'] : 1));
    }

    public static function validate($params) {
        if (!get_magic_quotes_gpc()) {
            foreach ($_POST as &$v) {
                if (empty($v)) { exit; }
                $v = addslashes($v);
            }
            try {
                DB::connectTest($_POST['user'], $_POST['pawd'], $_POST['name'], $_POST['host'], $_POST['port']);
                echo "{\"fail\":0,\"data\":\"\"}";
            } catch (Exception $e) {
                echo "{\"fail\":1,\"data\":\"{$e->getCode()}: {$e->getMessage()}\"}";
            }
        }
    }

    private static function _include($f) {
        if ($f >=1 && $f <= 4) {
            include "install/step/{$f}.php";
        } else {
            throw new Exception("", 404);
        }
    }
}