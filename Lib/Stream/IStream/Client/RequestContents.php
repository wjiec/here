<?php
/**
 * RequestContents.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Stream\IStream\Client;
use Here\Config\Constant\SysEnvironment;
use Here\Lib\Environment\GlobalEnvironment;


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
     * @return null|string
     */
    final public static function request_method(bool $lower_case = true): ?string {
        $request_method = GlobalEnvironment::get_server_env('request_method')
            ?? GlobalEnvironment::get_user_env(SysEnvironment::ENV_REQUEST_METHOD);
        return $lower_case ? strtolower($request_method) : $request_method;
    }

    /**
     * @return null|string
     */
    final public static function request_uri(): ?string {
        $request_uri = GlobalEnvironment::get_server_env('request_uri')
            ?? GlobalEnvironment::get_user_env(SysEnvironment::ENV_REQUEST_URI);

        $url_parts = parse_url($request_uri);
        return $url_parts['path'] ?? $request_uri;
    }

    /**
     * @param string $name
     * @param null|string $default
     * @return null|string
     */
    final public static function request_header(string $name, ?string $default = null) {
        if (self::$_request_headers === null) {
            if (function_exists('apache_request_headers')) {
                $headers = apache_request_headers();
            } else {
                $headers = self::apache_request_headers();
            }

            // lowercase
            foreach ($headers as $key => $value) {
                self::$_request_headers[strtolower($key)] = $value;
            }
        }

        return self::$_request_headers[strtolower($name)] ?? $default;
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
    final private static function apache_request_headers(): array {
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
