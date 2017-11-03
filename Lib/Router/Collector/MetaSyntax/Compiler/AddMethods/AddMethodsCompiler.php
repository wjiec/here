<?php
/**
 * AddMethodsCompiler.php.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector\MetaSyntax\Compiler\AddMethods;


use Here\Lib\Router\Collector\MetaSyntax\Compiler\MetaSyntaxCompilerInterface;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\MetaSyntaxCompilerResultInterface;

/**
 * Class AddMethodsCompiler
 * @package Here\Lib\Router\Collector\MetaSyntax\Compiler\AddMethods
 */
final class AddMethodsCompiler implements MetaSyntaxCompilerInterface {
    /**
     * @param array $value
     * @return MetaSyntaxCompilerResultInterface
     */
    final public static function compile(array $value): MetaSyntaxCompilerResultInterface {
        return new AddMethods();
    }
}
