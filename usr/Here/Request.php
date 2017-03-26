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

class Here_Request {
    /**
     * url prefix
     * @var string
     */
    private static $_url_prefix = null;

    /**
     * server variable
     * 
     * @var unknown
     */
    private $_server = array();

    public function __construct() {
        if (self::$_single_request_instance != null) {
            throw new Exception('Request must be single instance', 1996);
        }

        foreach ($_SERVER as $key => $value) {
            $this->_server[strtolower($key)] = $value;
        }

//         var_dump($this->_server);
    }

    public static function init_request() {
        self::$_single_request_instance = new Here_Request();
    }

    public static function redirection($url) {
        ob_clean();
        self::header('Location', $url);
    }

    public static function error($errno, $error) {
        header(_here_http_protocol_ . ' ' . $errno . $error);
    }

    public static function mime($suffix) {
        switch ($suffix) {
            case 'css': $mime = 'text/css'; break;
            case 'js': $mime = 'text/javascript'; break;
            default: $mime = 'text/plain'; break;
        }

        self::header('Content-Type', $mime . '; charset=' . _here_default_charset_);
    }

    public static function header($key, $value) {
        header($key . ':' . $value);
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
        $ua = strtolower($_SERVER['HTTP_USER_AGENT']);
        return (strpos($ua, 'iphone') || strpos($ua, 'ipad') || strpos($ua, 'android') || strpos($ua, 'midp') || strpos($ua, 'ucweb'));
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
