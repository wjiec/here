<?php
/**
 * @author ShadowMan
 * @package here::cookie
 */
class Cookie {
    private static $_path = '/';

    public static function setPath($path) {
        self::$_path = $path;
    }

    public static function set($name, $val, $expire = 0) {
        setrawcookie($name, rawurlencode($val), $expire, self::$_path);
        $_COOKIE[$name] = $val;
    }

    public static function get($key) {
        return isset($_COOKIE[$key]) ? $_COOKIE[$key] : null;
    }
}

?>