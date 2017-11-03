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


/**
 * Class RouterMiddleware
 * @package Here\Lib\Router\Collector\Middleware
 */
final class RouterMiddleware extends MetaComponent {
    /**
     * @var string
     */
    private $_middleware_name;

    /**
     * RouterMiddleware constructor.
     * @param string $name
     * @param array $meta
     */
    final public function __construct(string $name, array $meta) {
        $this->_middleware_name = $name;

        $allowed_syntax = AllowedMiddlewareSyntax::get_constants();
        $this->compile_values($allowed_syntax, $meta);
    }
}
