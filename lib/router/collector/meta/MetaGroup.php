<?php
/**
 * MetaGroup.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector\Meta;


/**
 * Class MetaGroup
 * @package Here\Lib\Router\Collector\Meta
 */
final class MetaGroup implements \IteratorAggregate, \Countable {
    /**
     * @var array
     */
    private $_meta_items;

    /**
     * MetaGroup constructor.
     */
    final public function __construct() {
        $this->_meta_items = array();
    }

    /**
     * @param MetaItem $item
     */
    final public function push_item(MetaItem $item) {
        $this->_meta_items[] = $item;
    }

    /**
     * @return \ArrayIterator
     */
    final public function getIterator() {
        return new \ArrayIterator($this->_meta_items);
    }

    /**
     * @return int
     */
    final public function count() {
        return \count($this->_meta_items);
    }

    /**
     * @return bool
     */
    final public function is_empty() {
        return empty($this->_meta_items);
    }
}
