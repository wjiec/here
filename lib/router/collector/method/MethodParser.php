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
use Here\Lib\Router\Collector\Method\Meta\MetaParser;


/**
 * Class MethodParser
 * @package Here\Lib\Router\Collector\Method
 */
final class MethodParser {
    /**
     * @var MetaParser
     */
    private $_meta_parser;

    /**
     * MethodParser constructor.
     */
    final public function __construct() {
        $this->_meta_parser = new MetaParser();
    }

    /**
     * @param \ReflectionMethod $method
     * @return MethodParseResult
     */
    final public function parse(\ReflectionMethod $method) {
        $result = new MethodParseResult($method->name);

        // not export method
        if (strpos($method->name, '_') === 0) {
            return $result->set_available(false);
        }

        // parse meta document
        $meta_group = $this->_meta_parser->parse($method->getDocComment());
        if ($meta_group === false || count($meta_group) === 0) { // empty meta_string or invalid meta
            return $result->set_available(false);
        }

        return $result->set_available(true);
    }

    /**
     * @return bool
     */
    final public function is_available() {
       return true;
    }
}
