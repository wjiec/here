<?php
/**
 * Dispatcher.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router;
use Here\Lib\Router\Collector\CollectorInterface;
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
     * Dispatcher constructor.
     * @param CollectorInterface $collector
     */
    final public function __construct(CollectorInterface $collector) {
        $this->_collector = $collector;
    }

    /**
     * @param string $request_method
     * @param string $request_uri
     */
    final public function dispatch(string $request_method, string $request_uri): void {
        // check method is allowed
        if (!AllowedMethods::contains($request_method)) {
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
