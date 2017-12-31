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
use Here\Config\Constant\SysConstant;
use Here\Lib\Router\Collector\CollectorInterface;
use Here\Lib\Router\Collector\DispatchError;
use Here\Lib\Router\Collector\RouterCollector;


/**
 * @TODO logger of any requests(DecoratorPattern)
 * @TODO request life-cycle(hook)
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
     * @var RouterRequest
     */
    private $_request;

    /**
     * @var RouterResponse
     */
    private $_response;

    /**
     * Dispatcher constructor.
     * @param CollectorInterface $collector
     */
    final public function __construct(CollectorInterface $collector) {
        $this->_collector = $collector;

        $this->_request = new RouterRequest();
        $this->_response = new RouterResponse();
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

        try {
            $trimmed_uri = trim($request_uri, SysConstant::URL_SEPARATOR);
            $channel = $this->_collector->dispatch($request_method, $trimmed_uri);

            var_dump($channel);
        } catch (DispatchError $exception) {
            $this->trigger_error($exception->get_error_code(), $exception->get_message());
        }
    }

    /**
     * @param int $error_code
     * @param array ...$args
     */
    final public function trigger_error(int $error_code, ...$args): void {
        RouterResponse::response_status_code($error_code);
        var_dump($error_code, $args);
    }
}
