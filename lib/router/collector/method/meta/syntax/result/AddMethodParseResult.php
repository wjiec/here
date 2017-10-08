<?php
/**
 * AddMethodParseResult.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector\Method\Meta\Syntax\Result;


/**
 * Class AddMethodParseResult
 * @package Here\Lib\Router\Collector\Method\Meta\Syntax\Result
 */
final class AddMethodParseResult implements MetaParseResultInterface, \IteratorAggregate, \Countable {
    /**
     * @var array
     */
    private $_methods;

    /**
     * AddMethodParseResult constructor.
     * @param array $methods
     */
    final public function __construct(array $methods) {
        $this->_methods = $methods;
    }

    /**
     * @return bool
     */
    public function is_available() {
        return $this->count() !== 0;
    }

    /**
     * @return \ArrayIterator
     */
    final public function getIterator() {
        return new \ArrayIterator($this->_methods);
    }

    /**
     * @return int
     */
    final public function count() {
        return \count($this->_methods);
    }
}
