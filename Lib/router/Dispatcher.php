<?php
/**
 * Router.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router;
use Here\Lib\Router\Collector\RouterCollector;


/**
 * Class Router
 * @package Here\Lib\Router
 */
final class Dispatcher {
    /**
     * @var RouterCollector
     */
    private $_collector;

    /**
     * Router constructor.
     * @param RouterCollector $collector
     */
    final public function __construct(RouterCollector $collector) {
        $this->_collector = $collector;
    }

    /**
     * @param null $request_method
     * @param null $request_uri
     */
    final public function dispatch($request_method, $request_uri) {
        // check method is allowed
        if (!AllowedMethods::check($request_method)) {
            $this->trigger_error(405, "`{$request_method}` is not allowed");
        }
    }

    /**
     * @param int $error_code
     * @param array ...$args
     */
    final public function trigger_error($error_code, ...$args) {
        var_dump($error_code, $args);
    }
}
