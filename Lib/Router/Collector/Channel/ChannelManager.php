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
use Here\Lib\Http\HttpStatusCode;
use Here\Lib\Router\Collector\Channel\Tree\ChannelTree;
use Here\Lib\Router\DispatchError;


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

    /**
     * @param string $request_method
     * @param $request_uri
     * @return RouterChannel|null
     * @throws DispatchError
     */
    final public function find_channel(string $request_method, $request_uri): ?RouterChannel {
        if (!isset($this->_channel_tree[$request_method])) {
            throw new DispatchError(HttpStatusCode::HTTP_STATUS_METHOD_NOT_ALLOWED, 'method not allowed');
        }

        return $this->_channel_tree[$request_method]->find_channel($request_uri);
    }
}
