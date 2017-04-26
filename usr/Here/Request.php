<?php
/**
 * Here Request Module
 * 
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016 ShadowMan
 * @license   MIT License
 * @link
 */

class Here_Request implements Here_Interfaces_SingleInstance {
    /**
     * url prefix
     * 
     * @var string
     */
    private static $_url_prefix = null;

    /**
     * server variable
     * 
     * @var array
     */
    private $_server = array();

    /** Here_Request constructor
     * 
     * @throws Exception
     */
    public function __construct() {
        if (self::$_single_request_instance != null) {
            throw new Exception('Request must be single instance', 1996);
        }

        foreach ($_SERVER as $key => $value) {
            $this->_server[strtolower($key)] = $value;
        }
    }

    public function is_mobile() {
        $user_agent = strtolower($this->get_server_env('http_user_agent'));
        return (strpos($user_agent, 'iphone') ||
            strpos($user_agent, 'ipad') ||
            strpos($user_agent, 'android') ||
            strpos($user_agent, 'midp') ||
            strpos($user_agent, 'ucweb'));
    }

    public function get_server_env($key) {
        $key = strtolower($key);

        if (array_key_exists($key, $this->_server)) {
            return $this->_server[$key];
        }
        return null;
    }

    /**
     * from $_SERVER getting value
     *
     * @param $key
     * @return string|null
     */
    public static function get_env($key) {
        return self::get_instance()->get_server_env($key);
    }

    public static function init_request() {
        self::$_single_request_instance = new Here_Request();
    }

    public static function redirection($url) {
        @ob_clean();

        self::header('Location', $url);
        exit();
    }

    public static function abort($errno, $error = null) {
        Core::router_instance()->emit_error($errno, $error);
    }

    public static function set_http_code($code) {
        header('Request-Status: ' . $code, null, $code);
    }

    public static function set_mime($suffix) {
        switch ($suffix) {
            case 'css': $mime = 'text/css'; break;
            case 'js': $mime = 'text/javascript'; break;
            case 'html': $mime = 'text/html'; break;
            default: return; /* Exit */
        }

        self::header('Content-Type', $mime . '; charset=' . _here_default_charset_);
    }

    public static function header($key, $value) {
        header($key . ': ' . $value);
    }

    /**
     * get request instance
     * 
     * @return Here_Request
     */
    public static function get_instance() {
        if (self::$_single_request_instance == null) {
            self::$_single_request_instance = new Here_Request();
        }
        return self::$_single_request_instance;
    }

    public static function url_completion($url) {
        return self::get_url_prefix() . (($url[0] == '/') ? $url : ('/' . $url));
    }

    public static function get_url_prefix() {
        if (self::$_url_prefix == null) {
            self::$_url_prefix = (self::is_secure() ? 'https' : 'http') . '://'
                    . (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : ($_SERVER['SERVER_NAME'])
                            . (isset($_SERVER['HTTP_HOST']) && in_array($_SERVER['SERVER_PORT'], [80, 443]) ? '' : $_SERVER['SERVER_PORT']));
        }
        return self::$_url_prefix;
    }

    private static function is_secure() {
        return (
            (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) != 'off') ||
            (!empty($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443')
        );
    }

    public static function get_request_headers() {
        if (!function_exists('apache_request_headers')) {
            function apache_request_headers() {
                $headers = array();
                $http_reg = '/\AHTTP_/';

                foreach($_SERVER as $key => $val) {
                    if(preg_match($http_reg, $key)) {
                        $arh_key = preg_replace($http_reg, '', $key);
                        $rx_matches = explode('_', $arh_key);

                        if(count($rx_matches) > 0 and strlen($arh_key) > 2) {
                            foreach($rx_matches as $ak_key => $ak_val) {
                                $rx_matches[$ak_key] = ucfirst($ak_val);
                            }

                            $arh_key = implode('-', $rx_matches);
                        }
                        $headers[$arh_key] = $val;
                    }
                }

                return($headers);
            }
        }

        return apache_request_headers();
    }

    # single instance
    private static $_single_request_instance = null;
}
