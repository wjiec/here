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
use Here\Lib\Ext\Regex\Regex;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\Component\ComponentBase;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\Rule\RuleParser;


/**
 * Class ValidUrlObject
 * @package Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl
 */
final class ValidUrl {
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
        return $this->_components[count($this->_components) - 1]->type;
    }

    /**
     * @return \stdClass
     */
    final public function pop_last(): \stdClass {
        return array_pop($this->_components);
    }

    /**
     * @param \stdClass $component
     */
    final private function _add_component(\stdClass $component): void {
        $this->_components[] = $component;
    }
}
