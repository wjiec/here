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
namespace Here\Lib;


/**
 * Class Request
 * @package Here\Lib
 */
class Request {
    /**
     * @var self
     */
    private static $_request;

    /**
     * @var array
     */
    private $_get_parameters;

    /**
     * @var array
     */
    private $_post_parameters;

    /**
     * @var array
     */
    private $_additional_get;

    /**
     * @var array
     */
    private $_additional_post;

    /**
     * @var string
     */
    private $_request_body;

    /**
     * Request constructor.
     */
    final public function __construct() {
        $this->_get_parameters = $_GET;
        $this->_post_parameters = $_POST;
        $this->_additional_get = array();
        $this->_additional_post = array();
        $this->_request_body = file_get_contents('php://input');

        // reset $_GET, $_POST and $_REQUEST
        $_GET = array();
        $_POST = array();
        $_REQUEST = array();
    }

    /**
     * @param string $name
     * @param mixed|null $default
     * @return mixed
     */
    final public static function get_param($name, $default = null) {
        self::_init_request();

        if (array_key_exists($name, self::$_request->_get_parameters)) {
            return self::$_request->_get_parameters[$name];
        }

        if (array_key_exists($name, self::$_request->_additional_get)) {
            return self::$_request->_additional_get[$name];
        }

        return $default;
    }

    /**
     * @param string $name
     * @param null $default
     * @return mixed|null
     */
    final public static function post_param($name, $default = null) {
        self::_init_request();

        if (array_key_exists($name, self::$_request->_post_parameters)) {
            return self::$_request->_post_parameters[$name];
        }

        if (array_key_exists($name, self::$_request->_additional_post)) {
            return self::$_request->_additional_post[$name];
        }

        return $default;
    }

    /**
     * @return string
     */
    final public static function text_body() {
        return self::$_request->_request_body;
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
     * @return string
     */
    final public static function request_method() {
        return Environment::get_server_env('request_method');
    }

    /**
     * @return string
     */
    final public static function request_uri() {
        return Environment::get_server_env('request_uri');
    }

    /**
     * initializing request module
     */
    final private static function _init_request() {
        if (self::$_request === null) {
            self::$_request = new self();
        }
    }
}
