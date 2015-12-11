<?php

class Controller_Installer {
    public static function step($params) {
        self::_load(intval(isset($_REQUEST['step']) ? $_REQUEST['step'] : 1));
    }

    private static function _load($s) {
        if ($s >=1 && $s <= 4) {
            include "install/step/{$s}.php";
        } else {
            exit;
        }
    }
}