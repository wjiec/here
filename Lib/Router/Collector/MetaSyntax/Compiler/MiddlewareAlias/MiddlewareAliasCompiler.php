<?php
/**
 * MiddlewareAliasCompiler.php.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector\MetaSyntax\Compiler\MiddlewareAlias;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\MetaSyntaxCompilerInterface;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\MetaSyntaxCompilerResultBase;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\MetaSyntaxCompilerResultInterface;


/**
 * Class MiddlewareAliasCompiler
 * @package Lib\Router\Collector\MetaSyntax\Compiler
 */
final class MiddlewareAliasCompiler implements MetaSyntaxCompilerInterface {
    /**
     * @param array $value
     * @return MetaSyntaxCompilerResultBase
     */
    final public static function compile(array $value): MetaSyntaxCompilerResultBase {
        $middleware_alias_component = new MiddlewareAlias();

        foreach ($value as $alias_name) {
            $middleware_alias_component->add_result($alias_name);
        }

        return $middleware_alias_component;
    }
}
