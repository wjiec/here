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
namespace Here\Lib\Router\Collector\DefaultRouter;
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
     * @middlewareAlias auth
     * @addLogger Authorization "%date %time - %host: %url[$query] %user@%password"
     */
    final public function authorization(RouterRequest $request, RouterResponse $response): bool {
        if (!$request::request_header('auth-token')) {
            return false;
        }
        return true;
    }
}
