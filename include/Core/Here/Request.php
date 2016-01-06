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
     * $_GET & $_POST 
     * @var array
     */
    private static $_params = [];

    const GET  = 1;
    const POST = 2;

    const USING_DB = 1;
    const USING_CM = 2;

    // XXX: Speed?
    public static function r($name) {
        if (empty(self::$_params)) {
            self::arrayMerge(self::$_params, $_GET, $_POST);
//             array_map(function(&$v) { }, self::$_params); TODO: delete?
        }
        if (array_key_exists($name, self::$_params)) {
            return self::$_params[$name];
        }
    }

    public static function getFullUrl($path = null) {
        return self::getUrlPrefix() . '/' . $path;
    }

    public static function getUrlPrefix() {
        if (empty(self::$_urlPrefix)) {
            self::$_urlPrefix = (self::isSecure() ? 'https' : 'http') . '://' .
                    (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST']
                        : ($_SERVER['SERVER_NAME']) .
                            (in_array($_SERVER['SERVER_PORT'], [80, 443]) ? ''
                                : $_SERVER['SERVER_PORT']));
        }
        return self::$_urlPrefix;
    }
    
    public static function isSecure() {
        return (
            (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) != 'off') ||
            (!empty($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443')
        );
    }
    // XXX: Speed?
    private static function arrayMerge(&$array) {
        $argc = func_num_args();
        $argv = func_get_args();
        
        for ($i = 1; $i < $argc; ++$i) {
            $array = array_merge($array, $argv[$i]);
        }
    }
}

?>