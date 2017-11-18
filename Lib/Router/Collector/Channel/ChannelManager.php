<?php
/**
 * ChannelManager.php
 *
 * @package   www
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector\Channel;
use Here\Lib\Router\Collector\Channel\Trie\ChannelTrie;


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
        var_dump($channel->get_methods_component());
        if ($channel->has_middleware_component()) {
            var_dump($channel->get_middleware_component());
        }
    }
}
