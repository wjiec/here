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


/**
 * Class ValidUrlObject
 * @package Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl
 */
final class ValidUrl {
    /**
     * @var array|string[]
     */
    private $_components;

    /**
     * ValidUrl constructor.
     */
    final public function __construct() {
        $this->_components = array();
    }

    /**
     * @param Regex $regex
     * @param null|string $name
     */
    final public function scalar_component(Regex $regex, ?string $name = null): void {
        $component = new \stdClass();

        $component->type = new ValidUrlType(ValidUrlType::VALID_URL_TYPE_SCALAR_PATH);
        $component->regex = $regex;
        $component->name = $name;

        $this->_add_component($component);
    }

    /**
     * @param ValidUrlType $type
     * @param Regex $regex
     * @param null|string $name
     */
    final public function complex_component(ValidUrlType $type, Regex $regex, ?string $name = null): void {
        $component = new \stdClass();

        $component->type = $type;
        $component->regex = $regex;
        $component->name = $name;

        $this->_add_component($component);
    }

    /**
     * @param ValidUrlType $type
     * @param string $scalar
     * @param Regex $regex
     * @param null|string $name
     */
    final public function composite_component(ValidUrlType $type, string $scalar, Regex $regex, ?string $name = null): void {
        $component = new \stdClass();

        $component->type = $type;
        $component->scalar = $scalar;
        $component->regex = $regex;
        $component->name = $name;

        $this->_add_component($component);
    }

    /**
     * @param string $name
     * @param null|string $attributes
     */
    final public function full_matched_component(string $name, ?string $attributes = null): void {
        $component = new \stdClass();

        $component->type = new ValidUrlType(ValidUrlType::VALID_URL_TYPE_FULL_MATCHED_PATH);
        $component->name = $name;
        $component->attributes = $attributes;

        $this->_add_component($component);
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
