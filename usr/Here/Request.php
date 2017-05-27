<?php
/**
 * Here Request Module
 *
 * Dependencies:
 *  *
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
     * 
     * @var string
     */
    private static $_url_prefix = null;

    /**
     * server variable
     * 
     * @var array
     */
    private static $_server = array();

    /**
     * GET parameters
     *
     * @var array
     */
    private static $_get_parameters = array();

    /**
     * POST parameters
     *
     * @var array
     */
    private static $_post_parameters = array();

    /**
     * request body contents
     *
     * @var string
     */
    private static $_request_contents;

    /** Here_Request constructor
     * 
     * @throws Exception
     */
    public function __construct() {
        // server variables
        foreach ($_SERVER as $key => $value) {
            self::$_server[strtolower($key)] = $value;
        }
        // request params
        self::$_get_parameters = $_GET;
        self::$_post_parameters = $_POST;
        // request body contents
        self::$_request_contents = file_get_contents('php://input');
    }

    /**
     * check client is mobile
     *
     * @return bool
     */
    public static function is_mobile() {
        $user_agent = strtolower(self::get_env('http_user_agent'));
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
     * @return string|null|array
     */
    public static function get_env($key = null) {
        // return all server variable
        if ($key === null) {
            return self::$_server;
        }
        // get single item
        $key = strtolower($key);
        if (array_key_exists($key, self::$_server)) {
            return self::$_server[$key];
        }
        return null;
    }

    /**
     * POST request body, if $json set true, than will decode contents to Json format
     *
     * @param bool $json
     * @param bool $assoc
     * @return string
     */
    public static function get_request_contents($json = false, $assoc = true) {
        if ($json == true) {
            return json_decode(self::$_request_contents, $assoc);
        }
        return self::$_request_contents;
    }

    /**
     * redirection to new url
     *
     * @param string $url
     */
    public static function redirection($url) {
        // clean output buffer
        ob_clean();
        // redirection to new address
        self::header('Location', $url);
        // no output
        exit();
    }

    /**
     * abort current request
     *
     * @param int $errno
     * @param string|null $error
     */
    public static function abort($errno, $error = null) {
        // using Router emit error handler
        Core::router_instance()->emit_error($errno, $error);
    }

    /**
     * set http error code
     *
     * @param int $code
     */
    public static function set_http_code($code) {
        header('X-Response-Status: ' . $code, null, $code);
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
        // content type header
        self::header('Content-Type', $mime . '; charset=' . _here_default_charset_);
    }

    /**
     * set http header
     *
     * @param string $key
     * @param string $value
     */
    public static function header($key, $value) {
        header(join(': ', array($key, $value)));
    }

    /**
     * check current connection is safe
     *
     * @return bool
     */
    public static function is_secure() {
        return (
            (self::get_env('https') && strtolower(self::get_env('https')) != 'off') ||
            (self::get_env('server_port') == '443')
        );
    }

    /**
     * get current web server prefix
     *
     * @return string
     */
    public static function get_url_prefix() {
        if (self::$_url_prefix == null) {
            self::$_url_prefix = join('', array(
                // http protocol
                self::is_secure() ? 'https' : 'http',
                // domain separator
                '://',
                // domain
                self::get_env('http_host') ?: self::get_env('server_name'),
                // if using non default port
                !in_array(self::get_env('server_port'), array(80, 443)) ? ':' : '',
                // server port
                !in_array(self::get_env('server_port'), array(80, 443)) ? self::get_env('server_port') : '',
            ));
        }
        return self::$_url_prefix;
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
     * url join
     *
     * @param string $base_path
     * @param array $concat_paths
     * @return string
     */
    public static function path_join($base_path, array $concat_paths) {
        return join(_here_url_separator_, array_merge(array(rtrim($base_path, _here_url_separator_)), array_map(function($path) {
            return trim($path, _here_url_separator_);
        }, $concat_paths)));
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

    /**
     * initializing all server parameters and environment
     *
     * @return Here_Request
     */
    public static function init_request() {
        return new Here_Request();
    }
}
