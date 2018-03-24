<?php
/**
 * RobotRejectFilter.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\App\Blogger\Filter;
use Here\Lib\Environment\GlobalEnvironment;
use Here\Lib\Extension\FilterChain\Proxy\FilterChainProxyBase;
use Here\Lib\Router\DispatchError;
use Here\Lib\Stream\IStream\Client\Request;
use Here\Lib\Stream\IStream\Client\RequestMethods;


/**
 * Class RobotRejectFilter
 * @package Here\App\Blogger\Filter
 */
final class RobotRejectFilter extends FilterChainProxyBase {
    /**
     * reject robot request
     *
     * @throws DispatchError
     */
    public function do_filter(): void {
        // only request is `POST`, we check it
        if (Request::request_method() === RequestMethods::POST && !Request::empty_post_params()) {
            // empty `http_referer`
            if (!GlobalEnvironment::get_env('http_referer')) {
                throw new DispatchError(403, 'are you human? (｡・`ω´･)');
            }

            // and `host` incorrect
            $url_parts = parse_url(GlobalEnvironment::get_env('http_referer'));
            if (!empty($url_parts['port'])) {
                $url_parts['host'] = "{$url_parts['host']}:{$url_parts['port']}";
            }

            if (empty($url_parts['host']) || GlobalEnvironment::get_env('http_host') != $url_parts['host']) {
                throw new DispatchError(403, 'you\'re not human. (╬￣皿￣)凸');
            }
        }

        // okay, you're a normal person, or a masked robot
        // and I wasn't impossible to distinguish one from the other.
        // so you cross this wall
        $this->next();
    }
}
