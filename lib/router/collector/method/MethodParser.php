<?php
/**
 * MethodParser.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector\Method;


/**
 * Class MethodParser
 * @package Here\Lib\Router\Collector\Method
 */
final class MethodParser {
    /**
     * @var \ReflectionMethod
     */
    private $_method_ref;

    /**
     * MethodParser constructor.
     * @param \ReflectionMethod $method
     */
    final public function __construct(\ReflectionMethod $method) {
        $this->_method_ref = $method;
    }
}
