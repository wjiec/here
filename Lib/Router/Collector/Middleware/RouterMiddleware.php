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
use Here\Lib\Router\Collector\MetaComponent;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\MiddlewareAlias\MiddlewareAlias;
use Here\Lib\Router\RouterCallback;


/**
 * Class RouterMiddleware
 * @package Here\Lib\Router\Collector\Middleware
 */
final class RouterMiddleware {
    /**
     * meta components utils
     */
    use MetaComponent;

    /**
     * @var string
     */
    private $_middleware_name;

    /**
     * RouterMiddleware constructor.
     * @param string $name
     * @param array $meta
     * @param RouterCallback $callback
     */
    final public function __construct(string $name, array $meta, RouterCallback $callback) {
        $this->_middleware_name = $name;

        $allowed_syntax = AllowedMiddlewareSyntax::get_constants();
        $this->compile_components($allowed_syntax, $meta);
    }

    /**
     * @return string
     */
    final public function get_middleware_name(): string {
        return $this->_middleware_name;
    }

    /**
     * @return bool
     */
    final public function has_alias_component(): bool {
        return $this->has_component(AllowedMiddlewareSyntax::MIDDLEWARE_SYNTAX_MIDDLEWARE_ALIAS);
    }

    /**
     * @return MiddlewareAlias
     * @throws MiddlewareAliasNotFound
     */
    final public function get_alias(): MiddlewareAlias {
        if (!$this->has_alias_component()) {
            throw new MiddlewareAliasNotFound("cannot found alias name to middleware `{$this->_middleware_name}`");
        }

        /* @var MiddlewareAlias $alias_component */
        $alias_component = $this->get_components(AllowedMiddlewareSyntax::MIDDLEWARE_SYNTAX_MIDDLEWARE_ALIAS);
        return $alias_component;
    }
}
