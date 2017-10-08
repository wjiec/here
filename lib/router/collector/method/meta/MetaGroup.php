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
namespace Here\Lib\Router\Collector\Method\Meta;


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
     * @param string $meta_string
     */
    final public function __construct($meta_string) {
        $this->_meta_items = array();

        $meta_string = self::_normalize_string($meta_string);
        $meta_lines = explode("\n", $meta_string);
        foreach ($meta_lines as $meta_line) {
            if (preg_match("/@(?<name>\w+) +(?<value>.*)/", $meta_line, $matches)) {
                $this->push_item(new MetaItem($matches['name'], $matches['value']));
            }
        }
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

    /**
     * @param string $meta_string
     * @return string
     */
    final private static function _normalize_string($meta_string) {
        return str_replace(array("\r\n", "\r"), "\n", $meta_string);
    }
}
