<?php
/**
 * AllowedMiddlewareSyntax.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector\Middleware;
use Here\Lib\Router\Collector\MetaSyntax\RouterComponentCommonSyntax;


/**
 * Class AllowedMiddlewareSyntax
 * @package Lib\Router\Collector\Middleware\Syntax
 */
final class AllowedMiddlewareSyntax extends RouterComponentCommonSyntax {
    /**
     * middleware component syntax: middlewareAlias
     */
    public const MIDDLEWARE_SYNTAX_MIDDLEWARE_ALIAS = 'middlewareAlias';
}
