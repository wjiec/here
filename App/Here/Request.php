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

    /**
     * request url part
     *
     * @var array
     */
    private static $_request_components;

    /** Here_Request constructor
     * 
     * @throws Exception
     */
    public function __construct() {
        // server variables
        foreach ($_SERVER as $key => $value) {
            self::$_server[strtolower($key)] = $value;
        }
        // url parameters
        self::$_get_parameters = $_GET;
        // post parameters
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

    /*
     * current request method, [lower case]
     */
    public static function request_method() {
        return strtolower(self::get_env('request_method'));
    }

    /**
     * current request path
     *
     * @return array|null|string
     */
    public static function request_url() {
        return self::get_env('request_uri');
    }

    /**
     * request path
     *
     * @return string
     */
    public static function request_path() {
        return self::_do_parse_url('path');
    }

    /**
     * request query component
     *
     * @param bool $assoc
     * @return string|array
     */
    public static function request_query($assoc = true) {
        $query = self::_do_parse_url('query');
        if ($assoc == false) {
            // origin query string
            return $query;
        }

        // convert to assoc array
        parse_str($query, $assoc_array);
        return $assoc_array;
    }

    /**
     * from $_SERVER getting value
     *
     * @param string $key
     * @param mixed $default
     * @return string|null|array
     */
    public static function get_env($key = null, $default = null) {
        // return all server variable
        if ($key === null) {
            return self::$_server;
        }
        // get single item
        $key = strtolower($key);
        if (array_key_exists($key, self::$_server)) {
            return self::$_server[$key];
        }
        return $default;
    }

    /**
     * from GET method getting parameter
     *
     * @param string|null $key
     * @param mixed $default
     * @return array|mixed|null
     */
    public static function get_parameter($key = null, $default = null) {
        if ($key == null) {
            return self::$_get_parameters;
        } else if (array_key_exists($key, self::$_get_parameters)) {
            return self::$_get_parameters[$key];
        }
        return $default;
    }

    /**
     * wrapper function of `get_parameter`
     *
     * @param string|null $key
     * @param mixed $default
     * @return array|mixed|null
     */
    public static function url_parameter($key = null, $default = null) {
        return self::get_parameter($key, $default);
    }

    /**
     * POST method request form data or parameters
     *
     * @param string|null $key
     * @param mixed $default
     * @return array|mixed|null
     */
    public static function post_parameter($key = null, $default = null) {
        if ($key == null) {
            return self::$_post_parameters;
        } else if (array_key_exists($key, self::$_post_parameters)) {
            return self::$_post_parameters[$key];
        }
        return $default;
    }

    /**
     * both GET and POST parameters
     *
     * @param string|null $key
     * @param mixed $default
     * @return array|mixed|null
     */
    public static function request_parameter($key = null, $default = null) {
        $get_parameter = self::get_parameter($key, $default);
        $post_parameter = self::post_parameter($key, $default);
        // check post parameters first
        if ($key != null && $post_parameter !== $default) {
            return $post_parameter;
        } else if ($key != null && $get_parameter !== $default) {
            return $get_parameter;
        }
        // both GET parameters and post parameters
        $request_parameters = array_merge(self::$_get_parameters, self::$_post_parameters);
        return $request_parameters;
    }

    /**
     * POST request body, if $json set true, than will decode contents to Json format
     *
     * @param bool $json
     * @param bool $assoc
     * @return string|array
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

    /**
     * parse url components
     *
     * @param string $key
     * @throws Here_Exceptions_FatalError
     * @return string
     */
    private static function _do_parse_url($key) {
        if (self::$_request_components == null) {
            self::$_request_components = parse_url(self::get_env('request_uri'));
        }
        if (!array_key_exists($key, self::$_request_components)) {
            throw new Here_Exceptions_FatalError("parse url components, key('{$key}') not found in components",
                'Here:Request:_do_parse_url');
        }
        return self::$_request_components[$key];
    }
}
