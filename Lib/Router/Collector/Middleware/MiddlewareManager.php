<?php
/**
 * MiddlewareManager.php.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector\Middleware;


/**
 * Class MiddlewareManager
 * @package Here\Lib\Router\Collector\Middleware
 */
final class MiddlewareManager {
    /**
     * @var array
     */
    private $_middlewares;

    /**
     * @var array
     */
    private $_middleware_alias;

    /**
     * MiddlewareManager constructor.
     */
    final public function __construct() {
    }

    /**
     * @param RouterMiddleware $middleware
     */
    final public function add_middleware(RouterMiddleware $middleware): void {

    }

    /**
     * @param string $middleware_name
     * @return RouterMiddleware
     */
    final public function get_middleware(string $middleware_name): RouterMiddleware {
        if (!$this->has_middleware($middleware_name)) {
            throw new MiddlewareNotFound("cannot found middleware, `{$middleware_name}`");
        }

        if (array_key_exists($middleware_name, $this->_middleware_alias)) {
            $middleware_name = $this->_middleware_alias[$middleware_name];
        }

        return $this->_middlewares[$middleware_name];
    }

    /**
     * @param string $middleware_name
     * @return bool
     */
    final public function has_middleware(string $middleware_name): bool {
        return array_key_exists($middleware_name, $this->_middlewares)
            || array_key_exists($middleware_name, $this->_middleware_alias);
    }
}
