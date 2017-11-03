<?php
/**
 * AddUrlCompiler.php.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\MetaSyntaxCompilerInterface;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\MetaSyntaxCompilerResultInterface;


/**
 * Class AddUrlCompiler
 * @package Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl
 */
final class AddUrlCompiler implements MetaSyntaxCompilerInterface {
    /**
     * @param array $value
     * @return MetaSyntaxCompilerResultInterface
     */
    final public static function compile(array $value): MetaSyntaxCompilerResultInterface {
        return new AddUrl();
    }
}
