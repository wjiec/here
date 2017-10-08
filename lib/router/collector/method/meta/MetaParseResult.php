<?php
/**
 * MetaParseResult.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector\Method\Meta;


/**
 * Class MetaParseResult
 * @package Here\Lib\Router\Collector\Method\Meta
 */
final class MetaParseResult implements \IteratorAggregate, \Countable {
    /**
     * @var array
     */
    private $_meta_items;

    /**
     * MetaParseResult constructor.
     */
    final public function __construct() {}

    /**
     * @param MetaItem $item
     */
    final public function set_item(MetaItem $item) {
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
}
