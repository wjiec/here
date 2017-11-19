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
     * @param AddMethods $methods
     * @param AddMiddleware $middleware
     * @param AddUrl $urls
     */
    final public function add_node(AddMethods $methods, AddMiddleware $middleware, AddUrl $urls): void {
    }
}
