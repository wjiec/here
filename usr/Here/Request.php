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

    public static function init_request() {
        self::$_single_request_instance = new Here_Request();
    }

    public static function redirection($url) {
        @ob_clean();

        self::header('Location', $url);
        exit();
    }

    public static function abort($errno, $error) {
        Core::router_instance()->emit_error($errno, $error);
    }

    public static function set_http_code($code) {
        header('Request-Status: ' . $code, null, $code);
    }

    public static function set_mime($suffix) {
        switch ($suffix) {
            case 'css': $mime = 'text/css'; break;
            case 'js': $mime = 'text/javascript'; break;
            default: $mime = 'text/plain'; break;
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

    # single instance
    private static $_single_request_instance = null;
}
