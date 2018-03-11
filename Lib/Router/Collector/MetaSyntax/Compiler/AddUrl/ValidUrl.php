<?php
/**
 * ValidUrl.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\Component\ComponentBase;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\Rule\RuleParser;


/**
 * Class ValidUrlObject
 * @package Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl
 */
final class ValidUrl implements \IteratorAggregate, \Countable {
    /**
     * @var array|ComponentBase[]
     */
    private $_components;

    /**
     * ValidUrl constructor.
     */
    final public function __construct() {
        $this->_components = array();
    }

    /**
     * @param ComponentBase $component
     * @throws InvalidRule
     */
    final public function add_component(ComponentBase $component): void {
        // check flag
        if (!empty($this->_components) && RuleParser::is_end_component($this)) {
            throw new InvalidRule("invalid of last segment");
        }

        $this->_components[] = $component;
    }

    /**
     * @return ValidUrlType
     */
    final public function last_component_type(): ValidUrlType {
        return $this->_components[count($this->_components) - 1]->get_type();
    }

    /**
     * @return ComponentBase
     */
    final public function pop_last(): ComponentBase {
        return array_pop($this->_components);
    }

    /**
     * @return ComponentBase
     */
    final public function glimpse_last(): ComponentBase {
        return $this->_components[count($this->_components) - 1];
    }

    /**
     * @return \ArrayIterator
     */
    final public function getIterator(): \ArrayIterator {
        return new \ArrayIterator($this->_components);
    }

    /**
     * @return int
     */
    public function count(): int {
        return \count($this->_components);
    }
}
