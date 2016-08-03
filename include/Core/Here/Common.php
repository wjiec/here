<?php
/**
 * @author ShadowMan
 * @package Here.Common
 */
class Common {
    /**
     * cookie path
     * 
     * @var string
     */
    private static $_cookiePath = '/';

    /**
     * sequential string
     * @var string
     */
    private static $_charSet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

    /**
     * disable cache operator
     */
    public static function disableCache() {
        header('Cache-Control: no-cache');
        header('Pragma: no-cache');
    }

    /**
     * variable(string or array) encode to JSON encoded string
     * @param string $value
     */
    public static function toJSON($value) {
        if (is_array($value)) {
            return json_encode($value);
        } else if (is_string($value)) {
            return json_encode($value, true);
        }
    }

    /**
     * Compatible practice
     * 
     * @param string $password
     * @param string $time
     */
    public static function pawdEncrypt($password, $time) {
        $length = strlen($password) / 2;
        $prev = substr($password, 0, $length);
        $end  = substr($password, $length);
        $end .= $time;

        return strtoupper(md5((substr(sha1($prev), 7, 15) . "F"))) . strtolower(md5((substr(sha1($end), 7, 15) . "F")));
    }

    /**
     * Compatible practice
     * 
     * @param string $password
     * @param string $encrypt
     * @param string $time
     */
    public static function pawdVerify($password, $encrypt, $time) {
        if (is_string($password) && is_string($encrypt)) {
            $temp = self::pawdEncrypt($password, $time);
            return $temp === $encrypt;
        } else {
            return false;
        }
    }

    /**
     * JSON encoded string to object or array
     * 
     * @param string $source
     * @param int $from
     */
    public static function jsonTo($source, $from = Common::JSON_TO_ARRAY) {
        switch ($from) {
            case Common::JSON_TO_ARRAY: return json_decode($source, true);
            case Common::JSON_TO_OBJECT: return json_decode($source);
            default: return null;
        }
    }

    /**
     * set cookie path
     * @param unknown $path
     */
    public static function cookiePath($path) {
        self::$_cookiePath = is_string($path) ? $path : '/';
    }

    public static function server($key) {
        return array_key_exists($key, $_SERVER) ? $_SERVER[$key] : null;
    }

#--------------- TODO COOKIE SESSION ----------------------

    public static function cookie($key, $val = null, $expire = 0) {
        if ($val == null && $expire == 0) {
            return isset($_COOKIE[$key]) ? $_COOKIE[$key] : null;
        }

        setrawcookie($key, rawurlencode($val), $expire, self::$_cookiePath);
    }

    public static function cookieSet($name, $val, $expire = 0) {
        setrawcookie($name, rawurlencode($val), $expire, self::$_cookiePath);
        $_COOKIE[$name] = $val;
    }

    public static function cookieGet($key) {
        return isset($_COOKIE[$key]) ? $_COOKIE[$key] : null;
    }

    public static function sessionSet($name, $val) {
        Core::sessionStart();

        $_SESSION[$name] = $val;
    }

    public static function sessionGet($name) {
        return isset($_SESSION[$name]) ? $_SESSION[$name] : null;
    }

    public static function earseSession($name) {
        if (isset($_SESSION[$name])) {
            unset($_SESSION[$name]);
        }
    }

    public static function recordSet($name, $val, $expire = 0) {
        self::cookieSet($name, $val, $expire);
        self::sessionSet($name, $val);
    }

    public static function recordGet($name) {
        return isset($_SESSION[$name]) ? $_SESSION[$name] : (isset($_COOKIE[$name]) ? $_COOKIE[$name] : null);
    }

#----------------------------------------------------------

    public static function randomString($length = 8) {
        return substr(self::_shuffleString(), 0, $length);
    }

    public static function prevClass() {
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3);
        $callerInformation = $backtrace[2];

        return array_key_exists('class', $callerInformation) ? $callerInformation['class'] : null;
    }

    public static function prevFunction() {
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3);
        $callerInformation = $backtrace[2];

        return array_key_exists('function', $callerInformation) ? $callerInformation['function'] : null;
    }

    public static function eDefault($conditions, $default = true, $htmlentities = false) {
        if ((is_string($conditions) || $conditions == null) && $default === true) {
            echo $conditions;
        }

        if ((is_string($default) || is_callable($default)) && ($conditions != null || $conditions == true || $conditions)) {
            if (is_callable($default)) {
                $default = $default();

                if (!is_string($default)) {
                    return;
                }
            }

            echo $htmlentities ? htmlentities($default) : $default;
        }
    }

    private static function _shuffleString() {
        return str_shuffle(self::$_charSet);
    }

    public static function shuffle(&$var) {
        if (gettype($var) == 'string') {
            $var = str_shuffle($var);
        } else if (gettype($var) == 'array') {
            $var = shuffle($var);
        } else {
            return null;
        }
    }

    const JSON_TO_ARRAY  = 'ARRAY';

    const JSON_TO_OBJECT = 'OBJECT';
}

?>