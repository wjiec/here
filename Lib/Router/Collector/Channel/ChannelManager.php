<?php
/**
 * ChannelManager.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector\Channel;
use Here\Lib\Router\Collector\Channel\Trie\ChannelTrie;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddMethods\AddMethods;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddMiddleware\AddMiddleware;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddMiddleware\AddMiddlewareCompiler;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\AddUrl;


/**
 * Class ChannelManager
 * @package Here\Lib\Router\Collector\Channel
 */
final class ChannelManager {
    /**
     * @var ChannelTrie
     */
    private $_channel_tree;

    /**
     * ChannelManager constructor.
     */
    final public function __construct() {
        $this->_channel_tree = new ChannelTrie();
    }

    /**
     * @param RouterChannel $channel
     */
    final public function add_channel(RouterChannel $channel): void {
        /* @var AddMethods $method_component */
        $method_component = $channel->get_methods_component();
        /* @var AddUrl $url_component */
        $url_component = $channel->get_url_component();

        /* @var AddMiddleware $middleware_component */
        $middleware_component = AddMiddlewareCompiler::compile(array());
        if ($channel->has_middleware_component()) {
            $middleware_component = $channel->get_middleware_component();
        }

        // push node to trie of the router
        $this->_channel_tree->add_node($method_component, $middleware_component, $url_component);
    }
}
