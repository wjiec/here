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
use Here\Lib\Router\Collector\Channel\Tree\ChannelTree;


/**
 * Class ChannelManager
 * @package Here\Lib\Router\Collector\Channel
 */
final class ChannelManager {
    /**
     * @var array|ChannelTree[]
     */
    private $_channel_tree;

    /**
     * ChannelManager constructor.
     */
    final public function __construct() {
        $this->_channel_tree = array();
    }

    /**
     * @param RouterChannel $channel
     * @throws \Here\Lib\Exceptions\Internal\ImpossibleError
     * @throws \Here\Lib\Router\Collector\MetaComponentNotFound
     */
    final public function add_channel(RouterChannel &$channel): void {
        /* @var $method string */
        foreach ($channel->get_methods_component() as $method) {
            if (!isset($this->_channel_tree[$method])) {
                $this->_channel_tree[$method] = new ChannelTree();
            }
            $this->_channel_tree[$method]->tree_parse($channel);
        }
    }
}
