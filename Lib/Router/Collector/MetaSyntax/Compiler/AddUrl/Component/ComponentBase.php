<?php
/**
 * ComponentBase.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\Component;
use Here\Lib\Extension\Regex\Regex;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\ValidUrlType;


/**
 * Class ComponentBase
 * @package Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\Component
 */
abstract class ComponentBase extends \stdClass implements ComponentInterface {
    /**
     * ComponentBase constructor.
     * @param ValidUrlType $type
     * @param Regex $regex
     * @param null|string $name
     */
    public function __construct(ValidUrlType $type, Regex $regex, ?string $name = null) {
        $this->_type = $type;
        $this->_name = $name;
        $this->_regex = $regex;
    }

    /**
     * @return ValidUrlType
     */
    final public function get_type(): ValidUrlType {
        return $this->_type;
    }

    /**
     * @return null|string
     */
    final public function get_name(): ?string {
        return $this->_name;
    }

    /**
     * @return Regex
     */
    final public function get_regex(): Regex {
        return $this->_regex;
    }
}
