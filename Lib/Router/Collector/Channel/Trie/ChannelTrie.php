<?php
/**
 * ChannelTrie.php
 *
 * @package   www
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector\Channel\Trie;


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
    public function __construct() {
        $this->_trie = array();
    }
}
