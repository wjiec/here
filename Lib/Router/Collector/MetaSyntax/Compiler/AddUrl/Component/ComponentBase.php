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
use Here\Lib\Ext\Regex\Regex;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\ValidUrlType;


/**
 * Class ComponentBase
 * @package Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\Component
 */
abstract class ComponentBase extends \stdClass {
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
     * @param string $name
     * @return null|string
     */
    final public function __get(string $name): ?string {
        if ($name[0] !== '_') {
            $name = "_{$name}";
        }
        return $this->{$name} ?? null;
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    final public function __set(string $name, $value): void {
        if ($name[0] !== '_') {
            $name = "_$name";
        }
        $this->{$name} = $value;
    }
}
