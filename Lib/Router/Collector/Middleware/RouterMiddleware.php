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
use Here\Lib\Router\RouterCallback;


/**
 * Class RouterMiddleware
 * @package Here\Lib\Router\Collector\Middleware
 */
final class RouterMiddleware extends MetaComponent {
    /**
     * RouterMiddleware constructor.
     * @param string $name
     * @param array $meta
     * @param RouterCallback $callback
     */
    final public function __construct(string $name, array $meta, RouterCallback $callback) {
        $this->set_component_name($name);
        $allowed_syntax = AllowedMiddlewareSyntax::get_constants();
        $this->compile_values($allowed_syntax, $meta);
    }
}
