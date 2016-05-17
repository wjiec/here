<?php
/**
 * @package Here.Intercepter
 * @author ShadowMan
 */
class Intercepter {
    public static function init() {
        if (!empty($_GET) || !empty($_POST)) {
            if (empty($_SERVER['HTTP_REFERER'])) {
                exit;
            }
        
            $parts = parse_url($_SERVER['HTTP_REFERER']);
            if (!empty($parts['port'])) {
                $parts['host'] = "{$parts['host']}:{$parts['port']}";
            }
        
            if (empty($parts['host']) || $_SERVER['HTTP_HOST'] != $parts['host']) {
                exit;
            }
        }
    }

    public static function token() {
        // TODO token
    }

    public static function check() {
        // TODO check token
    }
}

?>