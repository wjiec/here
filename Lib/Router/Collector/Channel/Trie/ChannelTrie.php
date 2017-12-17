<?php
/**
 * ChannelTrie.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector\Channel\Trie;
use Here\Lib\Router\Collector\Channel\RouterChannel;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddMethods\AddMethods;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddMiddleware\AddMiddleware;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\AddUrl;


/**
 * Class ChannelTrie
 * @package Here\Lib\Router\Collector\Channel\Trie
 */
final class ChannelTrie {
    /**
     * @var array
     */
    private $_trie;

    /**
     * ChannelTrie constructor.
     */
    final public function __construct() {
        $this->_trie = array();
    }

    /**
     * @param RouterChannel $channel
     */
    final public function add_node(RouterChannel $channel): void {
        /* @var AddMethods $method_component */
        $method_component = $channel->get_methods_component();
        /* @var AddUrl $url_component */
        $url_component = $channel->get_url_component();
        /* @var AddMiddleware|null $middleware_component */
        $middleware_component = null;
        if ($channel->has_middleware_component()) {
            $middleware_component = $channel->get_middleware_component();
        }

        var_dump($method_component, $url_component, $middleware_component);
        echo "\n";
    }
}
