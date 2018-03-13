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
    private static $_router_pairs = array();

    /**
     * @param string $name
     * @param string|null $value
     */
    final public static function push_router_pair(string $name, ?string $value): void {
        if ($value) {
            self::$_router_pairs[$name] = $value;
        }
    }

    /**
     * @param string $name
     */
    final public static function delete_router_pair(string $name): void {
        if (isset(self::$_router_pairs[$name])) {
            unset(self::$_router_pairs[$name]);
        }
    }

    /**
     * @param string $name
     * @param null|string $default
     * @return null|string
     */
    final public static function get_pair_value(string $name, ?string $default = null): ?string {
        return self::$_router_pairs[$name] ?? $default;
    }
}
