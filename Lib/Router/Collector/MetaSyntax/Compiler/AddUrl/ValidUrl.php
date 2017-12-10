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
    public function __construct() {
        $this->_components = array();
    }

    /**
     * @param Regex $regex
     * @param null|string $name
     */
    public function scalar_component(Regex $regex, ?string $name = null): void {
        $component = new \stdClass();

        $component->type = ValidUrlType::VALID_URL_TYPE_SCALAR_PATH;
        $component->regex = $regex;
        $component->name = $name;

        $this->_add_component($component);
    }

    /**
     * @param ValidUrlType $type
     * @param Regex $regex
     * @param null|string $name
     */
    public function complex_component(ValidUrlType $type, Regex $regex, ?string $name = null): void {
        $component = new \stdClass();

        $component->type = $type;
        $component->regex = $regex;
        $component->name = $name;

        $this->_add_component($component);
    }

    /**
     * @param string $scalar
     * @param Regex $regex
     * @param null|string $name
     */
    public function composite_component(string $scalar, Regex $regex, ?string $name = null): void {
        $component = new \stdClass();

        $component->type = ValidUrlType::VALID_URL_TYPE_COMPOSITE_PATH;
        $component->scalar = $scalar;
        $component->regex = $regex;
        $component->name = $name;

        $this->_add_component($component);
    }

    /**
     * @param string $name
     * @param null|string $attributes
     */
    public function full_matched_component(string $name, ?string $attributes = null): void {
        $component = new \stdClass();

        $component->type = ValidUrlType::VALID_URL_TYPE_FULL_MATCHED_PATH;
        $component->name = $name;
        $component->attributes = $attributes;

        $this->_add_component($component);
    }

    /**
     * @param \stdClass $component
     */
    private function _add_component(\stdClass $component): void {
        $this->_components[] = $component;
    }
}
