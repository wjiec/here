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
use Here\Config\Constant\SysConstant;
use Here\Lib\Exceptions\ExceptionBase;
use Here\Lib\Exceptions\GlobalExceptionHandler;
use Here\Lib\Extension\FilterChain\FilterChainContainer;
use Here\Lib\Router\Collector\Channel\RouterChannel;
use Here\Lib\Router\Collector\CollectorInterface;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddMiddleware\AddMiddleware;
use Here\Lib\Router\Collector\RouterCollector;


/**
 * @TODO logger of any requests(DecoratorPattern)
 */


/**
 * Class Router
 * @package Here\Lib\Router
 */
final class Dispatcher {
    /**
     * @var Dispatcher
     */
    private static $_self_instance;

    /**
     * @var RouterCollector
     */
    private $_collector;

    /**
     * Dispatcher constructor.
     * @param CollectorInterface $collector
     * @throws DispatchError
     */
    final public function __construct(CollectorInterface $collector) {
        /**
         * @TODO remove or hold this singleton mode
         */
        if (self::$_self_instance !== null) {
            throw new DispatchError(500, "Dispatcher must be singleton");
        }

        self::$_self_instance = $this;
        $this->_collector = $collector;
    }

    /**
     * @param string $request_method
     * @param string $request_uri
     */
    final public function dispatch(string $request_method, string $request_uri): void {
        /**
         * @TODO Filter Pattern { next() -> next() }
         * @TODO refactoring
         */

        try {
            // request has received
//            SysRouterLifeCycleHook::on_request_enter();
//            UserRouterLifeCycleHook::on_request_enter();

            // check request method
            if (!AllowedMethods::contains($request_method)) {
                throw new DispatchError(405, "`{$request_method}` is not allowed");
            }

            // find channel by request uri
            $trimmed_uri = trim($request_uri, SysConstant::URL_SEPARATOR);
            $channel = $this->_collector->dispatch($request_method, $trimmed_uri);

            // execute channel callback
            $this->exec_callback($channel);
        } catch (ExceptionBase $except) {
            do {
                // check DispatchError
                if ($except instanceof DispatchError) {
                    if ($this->trigger_error($except->get_error_code(), $except->get_message())) {
                        // has error handler, skip `trigger_exception`
                        break;
                    }
                }

                GlobalExceptionHandler::trigger_exception($except);
            } while (false);
        }

        // request will leave
//        UserRouterLifeCycleHook::on_response_leave();
//        SysRouterLifeCycleHook::on_response_leave();

        // response commit and exit
//        OutputBuffer::commit_buffer();
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

    /**
     * @param RouterChannel $channel
     */
    final private function exec_callback(RouterChannel $channel): void {
        try {
            $middleware = $channel->get_middleware_component();
            if ($middleware instanceof AddMiddleware) {
                // running middleware
                foreach ($middleware as $middleware_name) {
                    $this->_collector->start_middleware($middleware_name);
                }
            }

            // hook of callback before and middleware
            $channel->apply_callback();
            // hook if callback after and logger
        } catch (\ArgumentCountError $e) {}
    }
}
