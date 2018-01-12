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
use Here\Config\Router\UserRouterLifeCycleHook;
use Here\Lib\Exceptions\ExceptionBase;
use Here\Lib\Router\Collector\Channel\RouterChannel;
use Here\Lib\Router\Collector\CollectorInterface;
use Here\Lib\Router\Collector\DispatchError;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddMiddleware\AddMiddleware;
use Here\Lib\Router\Collector\RouterCollector;
use Here\Lib\Router\Hook\SysRouterLifeCycleHook;


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
    }

    /**
     * @param string $request_method
     * @param string $request_uri
     */
    final public function dispatch(string $request_method, string $request_uri): void {
        try {
            // request has received
            SysRouterLifeCycleHook::on_request_enter();
            UserRouterLifeCycleHook::on_request_enter();

            try {
                if (!AllowedMethods::contains($request_method)) {
                    throw new DispatchError(405, "`{$request_method}` is not allowed");
                }

                $trimmed_uri = trim($request_uri, SysConstant::URL_SEPARATOR);
                $channel = $this->_collector->dispatch($request_method, $trimmed_uri);

                $this->_exec_callback($channel);
            } catch (DispatchError $exception) {
                if (!$this->trigger_error($exception->get_error_code(), $exception->get_message())) {
                    throw $exception;
                }
            }

            UserRouterLifeCycleHook::on_response_leave();
            SysRouterLifeCycleHook::on_response_leave();
            // @TODO response flush take over
        } catch (ExceptionBase $except) {
            // @TODO SysDefaultHandler
            var_dump(strval($except));
        }
    }

    /**
     * @param RouterChannel $channel
     */
    final private function _exec_callback(RouterChannel $channel): void {
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

    /**
     * @param int $error_code
     * @param array ...$args
     * @return bool
     */
    final public function trigger_error(int $error_code, ...$args): bool {
        RouterResponse::response_status_code($error_code);
        try {
            return $this->_collector->trigger_error($error_code, ...$args);
        } catch (\ArgumentCountError $e) {}

        return true;
    }
}
