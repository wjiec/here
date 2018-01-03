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


/**
 * Trait DefaultMiddleware
 * @package Here\Lib\Router\Collector\Middleware
 */
trait DefaultMiddleware {
    /**
     * @return bool
     *
     * @routerMiddleware
     * @middlewareAlias auth
     * @addLogger Authorization "%date %time - %host: %url[$query] %user@%password"
     */
    final public function authorization(): bool {
        if (!RouterRequest::request_header('auth-token')) {
            return false;
        }
        return true;
    }
}
