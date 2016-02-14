<?php
/**
 * @author ShadowMan
 * @package Core.String
 */
class String {
    private static $_charSet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

    public static function pawdEncrypt($pawd, $raw = false) {
        return strtoupper(md5((substr(sha1($pawd), 7, 15) . "F")));
    }

    public static function randString($length) {
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