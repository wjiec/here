<?php
/**
 * Dispatcher.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router;
use Here\Lib\Exceptions\GlobalExceptionHandler;
use Here\Lib\Extension\Callback\CallbackObject;
use Here\Lib\Extension\FilterChain\FilterChainContainer;
use Here\Lib\Router\Collector\CollectorInterface;
use Here\Lib\Router\Collector\RouterCollector;
use Here\Lib\Router\Filter\CleanRequestUri;
use Here\Lib\Router\Filter\ExecuteChannel;
use Here\Lib\Router\Filter\MatchChannel;
use Here\Lib\Router\Filter\MethodAllowedFilter;


/**
 * @TODO logger of any requests(DecoratorPattern)
 */


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

        /* listening `DispatcherError` */
        GlobalExceptionHandler::when(DispatchError::class, new CallbackObject(
            function(DispatchError $e): bool {
                if ($this->trigger_error($e->get_error_code(), $e->get_message())) {
                    // has error handler, skip `trigger_exception`
                    return true;
                }

                /* trigger `GlobalExceptionHandler` */
                return false;
            }
        ));
    }

    /**
     * @param string $request_method
     * @param string $request_uri
     */
    final public function dispatch(string $request_method, string $request_uri): void {
        /* variable for channel reference */
        $channel = null;

        /* dispatcher chain */
        $container = new FilterChainContainer();

        /* `MethodAllowed` to check request method can be pass */
        $container->register_filter(new MethodAllowedFilter($request_method));

        /* `CleanRequestUri` to clean request uri */
        $container->register_filter(new CleanRequestUri($request_uri));

        /* `MatchChannel` to find channel by request uri */
        $container->register_filter(new MatchChannel($this->_collector, $request_method, $request_uri, $channel));

        /* `ExecuteChannel` to check middleware and start channel callback */
        $container->register_filter(new ExecuteChannel($this->_collector, $channel));

        /* start dispatcher */
        $container->start_filter();
    }

    /**
     * @param int $error_code
     * @param string $message
     * @return bool
     */
    final public function trigger_error(int $error_code, string $message): bool {
        RouterResponse::set_response_status_code($error_code);
        try {
            return $this->_collector->trigger_error($error_code, $message);
        } catch (\ArgumentCountError $e) {}

        return true;
    }
}
