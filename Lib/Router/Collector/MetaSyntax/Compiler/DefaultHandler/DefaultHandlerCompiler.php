<?php
/**
 * DefaultHandlerCompiler.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector\MetaSyntax\Compiler\DefaultHandler;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\MetaSyntaxCompilerInterface;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\MetaSyntaxCompilerResultBase;


/**
 * Class DefaultHandlerCompiler
 * @package Here\Lib\Router\Collector\MetaSyntax\Compiler\DefaultHandler
 */
final class DefaultHandlerCompiler implements MetaSyntaxCompilerInterface {
    /**
     * @param array $value
     * @return MetaSyntaxCompilerResultBase
     */
    final public static function compile(array $value): MetaSyntaxCompilerResultBase {
        return new DefaultHandler();
    }
}
