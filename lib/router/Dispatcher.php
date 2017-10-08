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
use Here\Lib\Ext\Singleton\SingletonPattern;
use Here\Lib\Router\Collector\RouterCollector;


/**
 * Class Router
 * @package Here\Lib\Router
 */
class Dispatcher {
    /**
     * Singleton
     */
    use SingletonPattern;

    /**
     * @var RouterCollector
     */
    private $_collector;

    /**
     * Router constructor.
     * @param RouterCollector $collector
     */
    final public function __construct(RouterCollector $collector) {
        self::set_instance($this);
        $this->_collector = $collector;
    }

    /**
     * @param null $request_method
     * @param null $request_uri
     */
    final public function dispatch($request_method, $request_uri) {
        // check method is allowed
        if (!in_array($request_method, self::ALLOWED_METHODS)) {
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

    /**
     * @var array
     */
    const ALLOWED_METHODS = array('get', 'post', 'put', 'update', 'patch', 'delete', 'options', 'head');
}
