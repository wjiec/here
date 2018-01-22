<?php
/**
 * MetaSyntaxCompilerInterface.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector\MetaSyntax\Compiler;


/**
 * Interface MetaSyntaxCompilerInterface
 * @package Lib\Router\Collector\MetaSyntax\Compiler
 */
interface MetaSyntaxCompilerInterface {
    /**
     * @param array $value
     * @return MetaSyntaxCompilerResultBase
     */
    public static function compile(array $value): MetaSyntaxCompilerResultBase;
}
