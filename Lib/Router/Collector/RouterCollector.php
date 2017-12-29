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
use Here\Lib\Router\Collector\Channel\ChannelManager;
use Here\Lib\Router\Collector\Channel\RouterChannel;
use Here\Lib\Router\Collector\Generator\RouterGenerator;
use Here\Lib\Router\Collector\Middleware\MiddlewareManager;
use Here\Lib\Router\Collector\Middleware\RouterMiddleware;
use Here\Lib\Router\RouterCallback;


/**
 * Class RouterCollector
 * @package Here\Lib\Router\Collector
 * @TODO life-cycle hook function
 */
abstract class RouterCollector implements CollectorInterface {
    /**
     * @var MiddlewareManager
     */
    private $_middleware_manager;

    /**
     * @var ChannelManager
     */
    private $_channel_manager;

    /**
     * RouterCollector constructor.
     * @throws Generator\UncertainRouterTypeError
     * @throws MetaComponentNotFound
     * @throws Middleware\DuplicateMiddleware
     * @throws \Here\Lib\Exceptions\Internal\ImpossibleError
     */
    final public function __construct() {
        $this->_middleware_manager = new MiddlewareManager();
        $this->_channel_manager = new ChannelManager();

        $this->_parse_methods();
    }

    /**
     * @throws Generator\UncertainRouterTypeError
     * @throws MetaComponentNotFound
     * @throws Middleware\DuplicateMiddleware
     * @throws \Here\Lib\Exceptions\Internal\ImpossibleError
     */
    final private function _parse_methods(): void {
        $ref = new \ReflectionClass(get_class($this));
        foreach ($ref->getMethods() as $method) {
            $callback = new RouterCallback(array($this, $method->name));

            if ($node = RouterGenerator::generate($method, $callback)) {
                if ($node instanceof RouterMiddleware) {
                    $this->_middleware_manager->add_middleware($node);
                } else if ($node instanceof RouterChannel) {
                    $this->_channel_manager->add_channel($node);
                }
            }
        }
        var_dump($this);
    }
}
