<?php
/**
 * FullMatchComponent.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\Component;
use Here\Lib\Ext\Regex\Regex;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\ValidUrlType;


/**
 * Class FullMatchComponent
 * @package Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\Component
 */
final class FullMatchComponent extends ComponentBase implements FullMatchComponentInterface {
    /**
     * FullMatchComponent constructor.
     * @param null|string $name
     * @param null|string $attributes
     */
    final public function __construct(?string $name = null, ?string $attributes) {
        parent::__construct(
            new ValidUrlType(ValidUrlType::VALID_URL_TYPE_FULL_MATCHED_PATH), new Regex('/^NOT_USE$/'), $name);

        $this->_attributes = $attributes;
        if ($this->_attributes === null) {
            $this->_attributes = strtoupper($this->_attributes);
        }
    }

    /**
     * @return string
     */
    public function get_attributes(): string {
        return $this->_attributes;
    }
}
