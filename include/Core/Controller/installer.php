<?php

class Controller_Installer {
    public static function step($params) {
        self::_load(intval(isset($_REQUEST['step']) ? $_REQUEST['step'] : 1));
    }
    
    public static function validate($params) {
        if (get_magic_quotes_gpc()) {
            echo $_POST['host'];
        }
    }

    private static function _load($s) {
        if ($s >=1 && $s <= 4) {
            include "install/step/{$s}.php";
        } else {
            exit;
        }
    }
}