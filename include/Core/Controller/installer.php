<?php

class Controller_Installer {
    public static function step() {
        if (!isset($_POST['step'])) {
            exit;
        }
        switch ($_POST['step']) {
            case '2': echo '2'; break;
            case '3': echo '3'; break;
            default: exit();
        }
    }
}