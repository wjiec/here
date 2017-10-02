<?php
/**
 * RouterCollector.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector;
use Here\Lib\Router\Collector\Meta\MetaGroup;
use Here\Lib\Router\Collector\Meta\MetaItem;


/**
 * Class RouterCollector
 * @package Here\Lib\Router\Collector
 */
abstract class RouterCollector {
    /**
     * RouterCollector constructor.
     */
    final public function __construct() {
        $ref = new \ReflectionClass(get_class($this));
        foreach ($ref->getMethods() as $method) {
            $this->_resolve_method($method);
        }
    }

    /**
     * @param \ReflectionMethod $method
     */
    final private function _resolve_method(\ReflectionMethod $method) {
        if (strpos($method->name, '_') === 0) {
            return;
        }

        $meta_group = $this->_resolve_meta_group($method->getDocComment());
        if ($meta_group->is_empty()) {
            return;
        }

        var_dump($meta_group);
    }

    /**
     * resolve
     */
    final public function resolve() {
    }

    /**
     * @param string $meta_string
     * @return MetaGroup
     */
    final private function _resolve_meta_group($meta_string) {
        $meta_string = $this->_normalize_meta_string($meta_string);
        $meta_lines = explode("\n", $meta_string);

        $meta_group = new MetaGroup();
        foreach ($meta_lines as $meta_line) {
            if (preg_match("/\@(?<name>\w+) +(?<value>.*)/", $meta_line, $matches)) {
                $meta_group->push_item(new MetaItem($matches['name'], $matches['value']));
            }
        }

        return $meta_group;
    }

    /**
     * @param string $meta_string
     * @return string
     */
    final private function _normalize_meta_string($meta_string) {
        $meta_string = str_replace(array("\r\n", "\r"), "\n", $meta_string);
        return $meta_string;
    }
}
