<?php
/**
 * RouterCollector.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector;
use Here\Lib\Router\Collector\Channel\RouterChannel;
use Here\Lib\Router\Collector\Generator\RouterGenerator;
use Here\Lib\Router\Collector\Middleware\MiddlewareManager;
use Here\Lib\Router\Collector\Middleware\RouterMiddleware;
use Here\Lib\Router\RouterCallback;


/**
 * Class RouterCollector
 * @package Here\Lib\Router\Collector
 */
abstract class RouterCollector implements CollectorInterface {
    /**
     * @var MiddlewareManager
     */
    private $_middleware_manager;

    /**
     * RouterCollector constructor.
     */
    final public function __construct() {
        $this->_middleware_manager = new MiddlewareManager();

        $this->_parse_methods();
        var_dump($this->_middleware_manager->get_middleware('auth'));
    }

    /**
     * parse all methods to available node
     */
    final private function _parse_methods(): void {
        $ref = new \ReflectionClass(get_class($this));
        foreach ($ref->getMethods() as $method) {
            $callback = new RouterCallback(array($this, $method->name));

            if ($node = RouterGenerator::generate($method, $callback)) {
                if ($node instanceof RouterMiddleware) {
                    $this->_middleware_manager->add_middleware($node);
                } else if ($node instanceof RouterChannel) {
//                    var_dump($node);
                }
            }
        }
    }
}
