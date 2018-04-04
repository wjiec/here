<?php
/**
 * Request.php
 *
 * @package   here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Stream\IStream\Client;
use Here\Lib\Environment\GlobalEnvironment;
use Here\Lib\Stream\IStream\Client\Parameters\GetParameter;
use Here\Lib\Stream\IStream\Client\Parameters\PostParameter;


/**
 * Class Request
 * @package Here\Stream\IStream\Client
 */
class Request {
    /**
     * get requests property/methods
     */
    use GetParameter;

    /**
     * post requests property/methods
     */
    use PostParameter;

    /**
     * request headers/body
     */
    use RequestContents;

    /**
     * @param string $name
     * @param null|string $default
     * @return null|string
     */
    final public static function request_param(string $name, ?string $default = null) {
        $get_param = self::url_param($name, $default);
        $post_param = self::post_param($name, $default);

        if ($get_param === $default && $post_param === $default) {
            return $default;
        } else if ($get_param === $default || $post_param === $default) {
            if ($get_param === $default) {
                return $post_param;
            }
            return $post_param;
        } else {
            if (self::request_method() === RequestMethods::POST) {
                return $post_param;
            }
            return $get_param;
        }
    }

    /**
     * @return string
     */
    final public static function client_ip(): string {
        $client = GlobalEnvironment::get_server_env('http_client_ip');
        $forward = GlobalEnvironment::get_server_env('http_x_forwarded_for');
        $remote = GlobalEnvironment::get_server_env('remote_addr');

        if ($client && filter_var($client, FILTER_VALIDATE_IP)) {
            return $client;
        } else if ($forward && filter_var($forward, FILTER_VALIDATE_IP)) {
            return $forward;
        }
        return $remote;
    }

    /**
     * @return bool
     */
    final public static function empty_request_params(): bool {
        return self::empty_get_params() && self::empty_post_params();
    }
}
