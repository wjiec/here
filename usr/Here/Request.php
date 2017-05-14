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

    /**
     * GET parameters
     *
     * @var array
     */
    private $_get_parameters = array();

    /**
     * POST parameters
     *
     * @var array
     */
    private $_post_parameters = array();

    /**
     * request body contents
     *
     * @var string
     */
    private $_request_contents;

    /** Here_Request constructor
     * 
     * @throws Exception
     */
    public function __construct() {
        if (self::$_single_request_instance != null) {
            throw new Exception('Request must be single instance', 1996);
        }
        // server variables
        foreach ($_SERVER as $key => $value) {
            $this->_server[strtolower($key)] = $value;
        }
        // request params
        $this->_get_parameters = $_GET;
        $this->_post_parameters = $_POST;
        // request body contents
        $this->_request_contents = file_get_contents('php://input');
    }

    /**
     * from server variables getting item
     *
     * @param string|null $key
     * @return array|mixed|null
     */
    public function get_server_env($key = null) {
        // return all server variable
        if ($key === null) {
            return $this->_server;
        }
        // get single item
        $key = strtolower($key);
        if (array_key_exists($key, $this->_server)) {
            return $this->_server[$key];
        }
        return null;
    }

    /**
     * check client is mobile
     *
     * @return bool
     */
    public static function is_mobile() {
        $user_agent = strtolower(self::get_server_env('http_user_agent'));
        return (strpos($user_agent, 'iphone') ||
            strpos($user_agent, 'ipad') ||
            strpos($user_agent, 'android') ||
            strpos($user_agent, 'midp') ||
            strpos($user_agent, 'ucweb'));
    }

    /**
     * from $_SERVER getting value
     *
     * @param string $key
     * @return string|null
     */
    public static function get_env($key) {
        return self::get_instance()->get_server_env($key);
    }

    /**
     * return server variables
     *
     * @return array
     */
    public static function get_server_variables() {
        return self::get_instance()->get_server_env();
    }

    /**
     * redirection to new url
     *
     * @param string $url
     */
    public static function redirection($url) {
        @ob_clean();

        self::header('Location', $url);
        exit();
    }

    /**
     * abort current request
     *
     * @param int $errno
     * @param string|null $error
     */
    public static function abort($errno, $error = null) {
        Core::router_instance()->emit_error($errno, $error);
    }

    /**
     * set http error code
     *
     * @param int $code
     */
    public static function set_http_code($code) {
        header('Request-Status: ' . $code, null, $code);
    }

    /**
     * set http-field for mime type
     *
     * @param $suffix
     */
    public static function set_mime($suffix) {
        switch ($suffix) {
            case 'css': $mime = 'text/css'; break;
            case 'js': $mime = 'text/javascript'; break;
            case 'html': $mime = 'text/html'; break;
            case 'json': $mime = 'text/json'; break;
            default: return; /* Exit */
        }

        self::header('Content-Type', $mime . '; charset=' . _here_default_charset_);
    }

    /**
     * set http header
     *
     * @param string $key
     * @param string $value
     */
    public static function header($key, $value) {
        header($key . ': ' . $value);
    }

    /**
     * getting complete url
     *
     * @param string $url
     * @return string
     */
    public static function url_completion($url) {
        return self::get_url_prefix() . (($url[0] == '/') ? $url : ('/' . $url));
    }

    /**
     * HTTP protocol, http:// or https://
     *
     * @return string
     */
    public static function get_url_prefix() {
        if (self::$_url_prefix == null) {
            self::$_url_prefix = (self::is_secure() ? 'https' : 'http') . '://'
                    . (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : ($_SERVER['SERVER_NAME'])
                            . (isset($_SERVER['HTTP_HOST']) && in_array($_SERVER['SERVER_PORT'], [80, 443]) ? '' : $_SERVER['SERVER_PORT']));
        }
        return self::$_url_prefix;
    }

    /**
     * check current connection is safe
     *
     * @return bool
     */
    private static function is_secure() {
        return (
            (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) != 'off') ||
            (!empty($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443')
        );
    }

    /**
     * get request headers
     *
     * @return array|false
     */
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

    /**
     * get remote/client ip address
     *
     * @return null|string
     */
    public static function get_remote_ip() {
        return self::get_env('remote_addr');
    }

    # single instance
    private static $_single_request_instance = null;

    /**
     * create Here_Request instance
     */
    public static function init_request() {
        self::$_single_request_instance = new Here_Request();
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
}
