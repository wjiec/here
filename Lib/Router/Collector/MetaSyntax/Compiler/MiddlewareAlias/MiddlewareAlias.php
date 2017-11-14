<?php
/**
 * MiddlewareAlias.php.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector\MetaSyntax\Compiler\MiddlewareAlias;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\MetaSyntaxCompilerResultBase;


/**
 * Class MiddlewareAlias
 * @package Lib\Router\Collector\MetaSyntax\Compiler\MiddlewareAlias
 */
final class MiddlewareAlias extends MetaSyntaxCompilerResultBase {
    /**
     * MiddlewareAlias constructor.
     * @param array $alias
     */
    final public function __construct(array $alias) {
        foreach ($alias as $middleware_name) {
            $this->add_result($middleware_name);
        }
    }
}
