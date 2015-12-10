<?php

class Controller_Installer {
    public static function step($params) {
        switch (intval(isset($_REQUEST['step']) ? $_REQUEST['step'] : 1)) {
            case '1': self::step1(); break;
            case '2': self::step2(); break;
            case '3': self::step3(); break;
            default: exit();
        }
    }
    
    public static function step1() {
        include 'install/step/1.php';
    }
    
    public static function step2() {
        include 'install/step/2.php';
    }
    
    public static function step3() {
        include 'install/step/3.php';
    }
}