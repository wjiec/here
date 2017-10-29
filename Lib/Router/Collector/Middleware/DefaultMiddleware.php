<?php
/**
 * DefaultMiddleware.php
 *
 * @package   here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector\Middleware;
use Here\Lib\Router\RouterRequest;
use Here\Lib\Router\RouterResponse;


/**
 * Trait DefaultMiddleware
 * @package Here\Lib\Router\Collector\Middleware
 */
trait DefaultMiddleware {
    /**
     * @param RouterRequest $request
     * @param RouterResponse $response
     * @return bool
     *
     * @routerMiddleware
     * @addLogger
     */
    final public function authorization(RouterRequest $request, RouterResponse $response): bool {
        if (!$request::url_param('uid')) {
            return false;
        }
        return true;
    }
}
