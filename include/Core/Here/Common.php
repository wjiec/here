<?php
/**
 * @author ShadowMan
 * @package Here.Common
 */
class Common {
    const JSON_TO_ARRAY  = 'ARRAY';
    const JSON_TO_OBJECT = 'OBJECT';

    private static $_cookiePath = '/';

    private static $_charSet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

    public static function noCache() {
        header('Cache-Control: no-cache');
        header('Pragma: no-cache');
    }

    public static function toJSON($value) {
        if (is_array($value)) {
            return json_encode($value);
        } else if (is_string($value)) {
            return json_encode($value, true);
        }
    }

    public static function jsonTo($source, $from = Common::JSON_TO_ARRAY) {
        switch ($from) {
            case Common::JSON_TO_ARRAY: return json_decode($source, true);
            case Common::JSON_TO_OBJECT: return json_decode($source);
            default: return null;
        }
    }

    public static function pawdEncrypt($password, $time) {
        $length = strlen($password) / 2;
        $prev = substr($password, 0, $length);
        $end  = substr($password, $length);
        $end .= $time;

        return strtoupper(md5((substr(sha1($prev), 7, 15) . "F"))) . strtolower(md5((substr(sha1($end), 7, 15) . "F")));
    }

    public static function pawdVerify($password, $encrypt, $time) {
        if (is_string($password) && is_string($encrypt)) {
            $temp = self::pawdEncrypt($password, $time);
            return $temp === $encrypt;
        } else {
            return false;
        }
    }

    public static function cookiePath($path) {
        self::$_cookiePath = is_string($path) ? $path : '/';
    }

    public static function cookieSet($name, $val, $expire = 0) {
        setrawcookie($name, rawurlencode($val), $expire, self::$_cookiePath);
        $_COOKIE[$name] = $val;
    }

    public static function cookieGet($key) {
        return isset($_COOKIE[$key]) ? $_COOKIE[$key] : null;
    }

    public static function sessionSet($name, $val) {
        $_SESSION[$name] = $val;
    }

    public static function sessionGet($name) {
        return isset($_SESSION[$name]) ? $_SESSION[$name] : null;
    }

    public static function recordSet($name, $val, $expire = 0) {
        self::cookieSet($name, $val, $expire);
        self::sessionSet($name, $val);
    }

    public static function recordGet($name) {
        return is_string($_SESSION[$name]) ? $_SESSION[$name] : (is_string($_COOKIE[$name]) ? $_COOKIE[$name] : null);
    }

    public static function randString($length = 8) {
        return substr(self::_shuffleString(), 0, $length);
    }

    private static function _shuffleString() {
        return str_shuffle(self::$_charSet);
    }

    private static function _shuffle(&$var) {
        if (gettype($var) == 'string') {
            $var = str_shuffle($var);
        } else if (gettype($var) == 'array') {
            $var = shuffle($var);
        } else {
            return null;
        }
    }
}

?>