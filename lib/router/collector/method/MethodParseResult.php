<?php
/**
 * MethodParseResult.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector\Method;
use Here\Lib\Assert;
use Here\Lib\Router\Collector\Method\Meta\MetaGroup;
use Here\Lib\Router\Collector\Method\Meta\MetaParseResult;


/**
 * Class MethodParseResult
 * @package Here\Lib\Router\Collector\Method
 */
final class MethodParseResult {
    /**
     * @var string
     */
    private $_method_name;

    /**
     * @var bool
     */
    private $_available;

    /**
     * @var MetaParseResult
     */
    private $_meta;

    /**
     * MethodParseResult constructor.
     * @param string $method_name
     */
    final public function __construct($method_name) {
        Assert::String($method_name);

        $this->_method_name = $method_name;
    }

    /**
     * @return string
     */
    final public function get_method_name() {
        return $this->_method_name;
    }

    /**
     * @param bool $available
     * @return $this
     */
    final public function set_available($available) {
        $this->_available = boolval($available);
        return $this;
    }

    /**
     * @return bool
     */
    final public function get_available() {
        return $this->_available ?: false;
    }

    /**
     * @param MetaParseResult $meta
     */
    final public function set_meta(MetaParseResult $meta) {
        $this->_meta = $meta;
    }

    /**
     * @return MetaParseResult
     */
    final public function get_meta() {
        return $this->_meta;
    }
}
