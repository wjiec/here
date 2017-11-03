<?php
/**
 * AddMiddlewareCompiler.php.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector\MetaSyntax\Compiler\AddMiddleware;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\MetaSyntaxCompilerInterface;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\MetaSyntaxCompilerResultInterface;


/**
 * Class AddMiddlewareCompiler
 * @package Here\Lib\Router\Collector\MetaSyntax\Compiler\AddMiddleware
 */
final class AddMiddlewareCompiler implements MetaSyntaxCompilerInterface {
    /**
     * @param array $value
     * @return MetaSyntaxCompilerResultInterface
     */
    final public static function compile(array $value): MetaSyntaxCompilerResultInterface {
        return new AddMiddleware();
    }
}
