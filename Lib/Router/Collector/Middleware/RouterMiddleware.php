<?php
/**
 * RouterMiddleware.php
 *
 * @package   here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector\Middleware;
use Here\Lib\Router\Collector\CollectorComponentBase;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\MiddlewareAlias\MiddlewareAlias;


/**
 * Class RouterMiddleware
 * @package Here\Lib\Router\Collector\Middleware
 */
final class RouterMiddleware extends CollectorComponentBase {
    /**
     * @return array
     */
    protected function allowed_syntax(): array {
        return AllowedMiddlewareSyntax::get_constants();
    }

    /**
     * @return MiddlewareAlias|null
     */
    final public function get_alias(): ?MiddlewareAlias {
        /* @var MiddlewareAlias|null $alias_component */
        $alias_component = $this->get_components(AllowedMiddlewareSyntax::MIDDLEWARE_SYNTAX_MIDDLEWARE_ALIAS);
        return $alias_component;
    }
}
