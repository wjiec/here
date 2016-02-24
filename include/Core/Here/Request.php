<?php
/**
 * @author ShadowMan 
 * @package Core.Request
 */
class Request {
    /**
     * url prefix 
     * @var string
     */
    private static $_urlPrefix = null;
    /**
     * GET POST PUT PATCH DELETE
     * @var array
     */
    private static $_params = [];
    /**
     * RESTful API value 
     * @var unknown
     */
    private static $_restValue = [];

    const RESTFUL = 1;

    // XXX: Speed
    public static function r($key, $mode = null) {
        if (empty(self::$_params)) {
            // RESTful API => PUT, PATCH, DELETE parse
            $params = file_get_contents('php://input');
            if (!empty($params)) {
                parse_str($params, $params);
            } else {
                $params = [];
            }
            self::$_params = array_merge(self::$_params, $_GET, $_POST, $params);
//             array_map(function(&$v) { var_dump(addslashes($v)); }, self::$_params);
        }
        if ($mode == null) {
            if (array_key_exists($key, self::$_params)) {
                return self::$_params[$key];
            } else {
                return null;
            }
        } else {
            if (array_key_exists($key, self::$_restValue)) {
                return self::$_restValue[$key];
            } else {
                return null;
            }
        }
    }

    public static function s($key, $val, $mode = null) {
        if ($mode == null) {
            self::$_params[$key] = $val;
        } else {
            self::$_restValue[$key] = $val;
        }
    }

    public static function getFullUrl($path = null) {
        return self::getUrlPrefix() . '/' . $path;
    }

    public static function noCache() {
        header('Cache-Control: no-cache');
        header('Pragma: no-cache');
    }

    private static function getUrlPrefix() {
        if (empty(self::$_urlPrefix)) {
            self::$_urlPrefix = (self::isSecure() ? 'https' : 'http') . '://'
                . (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : ($_SERVER['SERVER_NAME'])
                . (isset($_SERVER['HTTP_HOST']) && in_array($_SERVER['SERVER_PORT'], [80, 443]) ? '' : $_SERVER['SERVER_PORT']));
        }
        return self::$_urlPrefix;
    }

    private static function isSecure() {
        return (
            (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) != 'off') ||
            (!empty($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443')
        );
    }
}

?>