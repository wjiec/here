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
use Here\Lib\Router\Collector\Middleware\MiddlewareManager;
use Here\Lib\Router\Collector\Middleware\RouterMiddleware;
use \Here\Lib\Exceptions\Internal\ImpossibleError;
use Here\Lib\Router\RouterCallback;
use Here\Lib\Router\RouterRequest;


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
     * @throws Generator\ExplicitTypeDeclareMissing
     * @throws Middleware\DuplicateMiddleware
     * @throws ImpossibleError
     */
    final public function __construct() {
        $this->_middleware_manager = new MiddlewareManager();
        $this->_channel_manager = new ChannelManager();

        $this->_parse_methods();
    }

    /**
     * @param string $request_method
     * @param string $request_uri
     * @param RouterRequest $request
     * @return RouterChannel
     * @throws DispatchError
     */
    final public function dispatch(string $request_method, string $request_uri, RouterRequest $request): RouterChannel {
        $channel = $this->_channel_manager->find_channel($request_method, $request_uri, $request);

        if ($channel === null) {
            throw new DispatchError(HttpStatusCode::HTTP_STATUS_NOT_FOUND, 'Not Found');
        }
        return $channel;
    }

    /**
     * @throws Generator\ExplicitTypeDeclareMissing
     * @throws Middleware\DuplicateMiddleware
     * @throws ImpossibleError
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
    }
}
