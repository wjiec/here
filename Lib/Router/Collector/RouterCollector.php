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
use Here\Lib\Http\HttpStatusCode;
use Here\Lib\Router\Collector\Channel\ChannelManager;
use Here\Lib\Router\Collector\Channel\RouterChannel;
use Here\Lib\Router\Collector\Generator\RouterGenerator;
use Here\Lib\Router\Collector\Handler\HandlerManager;
use Here\Lib\Router\Collector\Handler\RouterHandler;
use Here\Lib\Router\Collector\Middleware\MiddlewareManager;
use Here\Lib\Router\Collector\Middleware\RouterMiddleware;
use \Here\Lib\Exceptions\Internal\ImpossibleError;
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
     * @var HandlerManager
     */
    private $_handler_manager;

    /**
     * RouterCollector constructor.
     * @throws Generator\ExplicitTypeDeclareMissing
     * @throws Handler\DuplicateDefaultHandler
     * @throws Handler\InvalidRouterHandler
     * @throws ImpossibleError
     * @throws Middleware\DuplicateMiddleware
     */
    final public function __construct() {
        $this->_middleware_manager = new MiddlewareManager();
        $this->_channel_manager = new ChannelManager();
        $this->_handler_manager = new HandlerManager();

        $this->_parse_methods();
    }

    /**
     * @param string $request_method
     * @param string $request_uri
     * @return RouterChannel
     * @throws DispatchError
     */
    final public function dispatch(string $request_method, string $request_uri): RouterChannel {
        $channel = $this->_channel_manager->find_channel($request_method, $request_uri);

        if ($channel === null) {
            throw new DispatchError(HttpStatusCode::HTTP_STATUS_NOT_FOUND, 'Not Found');
        }
        return $channel;
    }

    /**
     * @param string $middleware_name
     * @throws MiddlewareError
     * @throws \ArgumentCountError
     */
    final public function start_middleware(string $middleware_name): void {
        if (!$this->_middleware_manager->has_middleware($middleware_name)) {
            throw new MiddlewareError(500, "middleware `{$middleware_name}` not found");
        }

        /* @var RouterMiddleware $middleware */
        if (($middleware = $this->_middleware_manager->get_middleware($middleware_name))) {
            $middleware->apply_callback();
        }
    }

    /**
     * @param int $error_code
     * @param string $message
     * @return bool
     * @throws \ArgumentCountError
     */
    final public function trigger_error(int $error_code, string $message): bool {
        $handler = $this->_handler_manager->get_handler($error_code);
        if ($handler === null) {
            $handler = $this->_handler_manager->get_default_handler();
            if ($handler === null) {
                return false;
            }
        }
        $handler->apply_callback($message);
        return true;
    }

    /**
     * @throws Generator\ExplicitTypeDeclareMissing
     * @throws Handler\DuplicateDefaultHandler
     * @throws Handler\InvalidRouterHandler
     * @throws ImpossibleError
     * @throws Middleware\DuplicateMiddleware
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
                } else if ($node instanceof RouterHandler) {
                    $this->_handler_manager->add_handler($node);
                }
            }
        }
    }
}
