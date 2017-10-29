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
            if (self::request_method() === 'post') {
                return $post_param;
            }
            return $get_param;
        }
    }
}
