<?php
/**
 * RouterRequest.php
 *
 * @package   here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router;
use Here\Lib\Stream\IStream\Client\Request;


/**
 * Class RouterRequest
 * @package Here\Lib\Router
 */
class RouterRequest extends Request {
    /**
     * @var array
     */
    private static $_route_parameters = array();

    /**
     * @param string $name
     * @param string|null $value
     */
    final public static function add_route_param(string $name, ?string $value): void {
        if ($value) {
            self::$_route_parameters[$name] = $value;
        }
    }

    /**
     * @param string $name
     */
    final public static function delete_router_param(string $name): void {
        if (isset(self::$_route_parameters[$name])) {
            unset(self::$_route_parameters[$name]);
        }
    }

    /**
     * @param string $name
     * @param null|string $default
     * @return null|string
     */
    final public static function route_param(string $name, ?string $default = null): ?string {
        return self::$_route_parameters[$name] ?? $default;
    }
}
