<?php
/**
 * Created by PhpStorm.
 * User: ShadowMan
 * Date: 2017/10/26
 * Time: 22:46
 */
namespace Here\Lib\Stream\IStream\Client;
use Here\Lib\Env\GlobalEnvironment;


/**
 * Trait RequestHeader
 * @package Here\Lib\Stream\IStream\Client
 */
trait RequestContents {
    /**
     * @var array
     */
    private static $_request_headers;

    /**
     * @var string
     */
    private static $_request_body;

    /**
     * @var string
     */
    private static $_request_method;

    /**
     * @param bool $lower_case
     * @return string
     */
    final public static function request_method(bool $lower_case = true): string {
        if ($lower_case) {
            return strtolower(GlobalEnvironment::get_server_env('request_method'));
        }
        return GlobalEnvironment::get_server_env('request_method');
    }

    /**
     * @return string
     */
    final public static function request_uri(): string {
        return GlobalEnvironment::get_server_env('request_uri');
    }

    /**
     * @param string $name
     * @param null|string $default
     * @return null|string
     */
    final public static function request_header(string $name, ?string $default = null) {
        if (self::$_request_headers === null) {
            if (function_exists('apache_request_headers')) {
                self::$_request_headers = apache_request_headers();
            } else {
                self::$_request_headers = self::_apache_request_headers();
            }
        }

        return self::$_request_headers[$name] ?? $default;
    }

    /**
     * @return string
     */
    final public static function request_body(): string {
        if (self::$_request_body === null) {
            self::$_request_body = file_get_contents('php://input');
        }
        return self::$_request_body;
    }

    /**
     * @return array
     */
    final private static function _apache_request_headers(): array {
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
