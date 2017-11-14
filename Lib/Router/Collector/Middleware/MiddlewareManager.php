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
    private $_middleware_pool;

    /**
     * @var array
     */
    private $_middleware_alias;

    /**
     * MiddlewareManager constructor.
     */
    final public function __construct() {
        $this->_middleware_alias = array();
        $this->_middleware_pool = array();
    }

    /**
     * @param RouterMiddleware $middleware
     * @throws DuplicateMiddleware
     */
    final public function add_middleware(RouterMiddleware $middleware): void {
        $middleware_name = $middleware->get_middleware_name();
        if ($this->has_middleware($middleware_name)) {
            throw new DuplicateMiddleware("the same middleware name by `{$middleware_name}`");
        }

        $this->_middleware_pool[$middleware_name] = $middleware;
        if ($middleware->has_alias_component()) {
            $alias = $middleware->get_alias();
            foreach ($alias as $middleware_alias) {
                $this->_middleware_alias[$middleware_alias] = &$this->_middleware_pool[$middleware_name];
            }
        }
    }

    /**
     * @param string $middleware_name
     * @return RouterMiddleware
     * @throws MiddlewareNotFound
     */
    final public function get_middleware(string $middleware_name): RouterMiddleware {
        if (!$this->has_middleware($middleware_name)) {
            throw new MiddlewareNotFound("cannot found middleware, `{$middleware_name}`");
        }

        if (isset($this->_middleware_alias[$middleware_name])) {
            return $this->_middleware_alias[$middleware_name];
        }

        return $this->_middleware_pool[$middleware_name];
    }

    /**
     * @param string $middleware_name
     * @return bool
     */
    final public function has_middleware(string $middleware_name): bool {
        return array_key_exists($middleware_name, $this->_middleware_pool)
            || array_key_exists($middleware_name, $this->_middleware_alias);
    }
}
