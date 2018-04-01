<?php
/**
 * ExecuteChannel.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Filter;
use Here\Lib\Extension\FilterChain\Proxy\FilterChainProxyBase;
use Here\Lib\Router\Collector\Channel\RouterChannel;
use Here\Lib\Router\Collector\CollectorInterface;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddMiddleware\AddMiddleware;
use Here\Lib\Router\Collector\MiddlewareError;
use Here\Lib\Router\DispatchError;


/**
 * Class ExecuteChannel
 * @package Here\Lib\Router\Filter
 */
final class ExecuteChannel extends FilterChainProxyBase {
    /**
     * @var CollectorInterface
     */
    private $_collector;

    /**
     * @var RouterChannel
     */
    private $_channel;

    /**
     * ExecuteChannel constructor.
     * @param CollectorInterface $collector
     * @param RouterChannel|null $channel
     */
    final public function __construct(CollectorInterface &$collector, ?RouterChannel &$channel) {
        $this->_collector = &$collector;
        $this->_channel = &$channel;
    }


    /**
     * 1. check middleware exists
     *  i. start all middleware and check it
     * 2. apply channel callback
     *
     * @throws DispatchError
     */
    final public function do_filter(): void {
        try {
            $middleware = $this->_channel->get_middleware_component();
            if ($middleware instanceof AddMiddleware) {
                // running middleware
                foreach ($middleware as $middleware_name) {
                    $this->_collector->start_middleware($middleware_name);
                }
            }

            // hook of callback before and middleware
            $this->_channel->apply_callback();

            // hook if callback after and logger
        } catch (MiddlewareError $e) {
            throw new DispatchError($e->get_error_code(), $e->get_message());
        } catch (\ArgumentCountError $e) {}
    }
}
