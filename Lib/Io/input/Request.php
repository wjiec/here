<?php
/**
 * Request.php
 *
 * @package   Here\Lib
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Io\Input;
use Here\Lib\Environment;
use Here\Lib\Io\Filter\IoFilterBase;


/**
 * Class Request
 * @package Here\Lib
 */
final class Request {
    /**
     * @var array
     */
    private static $_get_parameters;

    /**
     * @var array
     */
    private static $_post_parameters;

    /**
     * @var array
     */
    private static $_additional_get;

    /**
     * @var array
     */
    private static $_additional_post;

    /**
     * @var string
     */
    private static $_request_body;

    /**
     * @var array
     */
    private static $_request_headers;

    /**
     * @param string $name
     * @param mixed|null $default
     * @return mixed
     */
    final public static function get_param($name, $default = null) {
        if (self::$_get_parameters === null || self::$_additional_get === null) {
            self::$_get_parameters = $_GET;
            self::$_additional_get = array();

            // reset GET
            $_GET = array();
            $_REQUEST = array();
        }

        // original GET parameters
        if (array_key_exists($name, self::$_get_parameters)) {
            return self::$_get_parameters[$name];
        }

        // additional GET parameters
        if (array_key_exists($name, self::$_additional_get)) {
            return self::$_additional_get[$name];
        }

        return $default;
    }

    /**
     * @param IoFilterBase $filter
     * @param string $name
     * @param null $default
     * @return string
     */
    final public static function get_param_safe(IoFilterBase $filter, $name, $default = null) {
        return $filter->apply(self::get_param($name, $default), $default);
    }

    /**
     * @param string $name
     * @param null $default
     * @return mixed|null
     */
    final public static function post_param($name, $default = null) {
        if (self::$_post_parameters === null || self::$_additional_post === null) {
            self::$_post_parameters = $_POST;
            self::$_additional_post = array();

            // reset POST
            $_POST = array();
            $_REQUEST = array();
        }


        // original POST parameters
        if (array_key_exists($name, self::$_post_parameters)) {
            return self::$_post_parameters[$name];
        }

        // additional POST parameters
        if (array_key_exists($name, self::$_additional_post)) {
            return self::$_additional_post[$name];
        }

        return $default;
    }

    /**
     * @param IoFilterBase $filter
     * @param string $name
     * @param null|mixed $default
     * @return string
     */
    final public static function post_param_safe(IoFilterBase $filter, $name, $default = null) {
        return $filter->apply(self::post_param($name, $default), $default);
    }

    /**
     * @param string $name
     * @param mixed|null $default
     * @return string
     */
    final public static function request_param($name, $default = null) {
        if (in_array(self::request_method(), array('get', 'post'))) {
            if (self::request_method() === 'get') {
                return self::get_param($name, $default);
            }
            return self::post_param($name, $default);
        }

        $params = self::json_body();
        if ($params === null || empty($params)) {
            return $default;
        }
        if (array_key_exists($name, $params)) {
            return $params[$name];
        }
        return $default;
    }

    /**
     * @param IoFilterBase $filter
     * @param string $name
     * @param null|mixed $default
     * @return string
     */
    final public static function request_param_safe(IoFilterBase $filter, $name, $default = null) {
        return $filter->apply(self::request_param($name, $default), $default);
    }

    /**
     * @return string
     */
    final public static function text_body() {
        if (self::$_request_body === null) {
            self::$_request_body = file_get_contents('php://input');
        }

        return self::$_request_body;
    }

    /**
     * @return array|null
     */
    final public static function json_body() {
        return json_decode(self::text_body(), true);
    }

    /**
     * @return array|false
     */
    final public static function get_request_headers() {
        if (self::$_request_headers === null) {
            // check function `apache_request_headers` exists
            if (!function_exists('apache_request_headers')) {
                // defined it
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

                    return $headers;
                }
            }

            // assign headers
            self::$_request_headers = apache_request_headers();
        }

        return self::$_request_headers;
    }

    /**
     * @param string $name
     * @param mixed|null $default
     * @return string
     */
    final public static function request_header($name, $default = null) {
        if (self::$_request_headers === null) {
            // initializing request headers
            self::get_request_headers();
        }

        if (array_key_exists($name, self::$_request_headers)) {
            return self::$_request_headers[$name];
        }
        return $default;
    }

    /**
     * @return string
     */
    final public static function request_method() {
        return strtolower(Environment::get_server_env('request_method'));
    }

    /**
     * @return string
     */
    final public static function request_uri() {
        return Environment::get_server_env('request_uri');
    }
}
