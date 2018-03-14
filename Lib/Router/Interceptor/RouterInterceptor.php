<?php
/**
 * RouterInterceptor.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Interceptor;
use Here\Lib\Environment\GlobalEnvironment;
use Here\Lib\Router\DispatchError;
use Here\Lib\Stream\IStream\Client\Request;
use Here\Lib\Stream\IStream\Client\RequestMethods;


/**
 * Class RouterInterceptor
 * @package Here\Lib\Router\Interceptor
 */
final class RouterInterceptor {
    /**
     * @return bool
     * @throws DispatchError
     */
    final public static function reject_robot(): bool {
        if (Request::request_method() === RequestMethods::POST && !Request::empty_post_params()) {
            if (!GlobalEnvironment::get_env('http_referer')) {
                throw new DispatchError(403, 'are you human? (｡・`ω´･)');
            }

            $url_parts = parse_url(GlobalEnvironment::get_env('http_referer'));
            if (!empty($url_parts['port'])) {
                $url_parts['host'] = "{$url_parts['host']}:{$url_parts['port']}";
            }

            if (empty($url_parts['host']) || GlobalEnvironment::get_env('http_host') != $url_parts['host']) {
                throw new DispatchError(403, 'you\'re not human. (╬￣皿￣)凸');
            }
        }

        return true;
    }
}
