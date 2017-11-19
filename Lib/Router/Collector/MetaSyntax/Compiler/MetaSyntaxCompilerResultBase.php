<?php
/**
 * MetaSyntaxCompilerBase.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector\MetaSyntax\Compiler;


/**
 * Class MetaSyntaxCompilerBase
 * @package Here\Lib\Router\Collector\MetaSyntax\Compiler
 */
abstract class MetaSyntaxCompilerResultBase implements MetaSyntaxCompilerResultInterface, \IteratorAggregate {
    /**
     * @var array
     */
    private $_results = array();

    /**
     * MetaSyntaxCompilerResultBase constructor.
     */
    final public function __construct() {}

    /**
     * @param $value
     * @param null|string $name
     * @param bool $override
     * @throws MetaSyntaxResultOverride
     */
    final public function add_result($value, ?string $name = null, bool $override = true): void {
        if ($name === null) {
            $this->_results[] = $value;
        } else {
            if ($override === false && isset($this->_results[$name])) {
                throw new MetaSyntaxResultOverride("cannot override `{$name}`");
            }
            $this->_results[$name] = $value;
        }
    }

    /**
     * @return \ArrayIterator
     */
    final public function getIterator(): \ArrayIterator {
        return new \ArrayIterator($this->_results);
    }
}
