<?php
/**
 * MatchChannel.php
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


/**
 * Class MatchChannel
 * @package Here\Lib\Router\Filter
 */
final class MatchChannel extends FilterChainProxyBase {
    /**
     * @var CollectorInterface
     */
    private $_collector;

    /**
     * @var string
     */
    private $_request_method;

    /**
     * @var string
     */
    private $_request_uri;

    /**
     * @var RouterChannel|null
     */
    private $_channel;

    /**
     * MatchChannel constructor.
     * @param CollectorInterface $collector
     * @param string $request_method
     * @param string $request_uri
     * @param RouterChannel|null $channel
     */
    final public function __construct(CollectorInterface $collector, string &$request_method, string &$request_uri,
                                      ?RouterChannel &$channel) {
        $this->_collector = &$collector;
        $this->_request_method = &$request_method;
        $this->_request_uri = &$request_uri;
        $this->_channel = &$channel;
    }

    /**
     * 1. check request method tree exists
     * 2. find channel by request_uri
     */
    final public function do_filter(): void {
        $this->_channel = $this->_collector->dispatch($this->_request_method, $this->_request_uri);

        $this->next();
    }
}
