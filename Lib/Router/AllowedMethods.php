<?php
/**
 * AllowedMethods.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router;


/**
 * Class AllowedMethods
 * @package Here\Lib\Router
 */
final class AllowedMethods {
    /**
     * allowed methods for request
     */
    const ALLOWED_METHODS = array('get', 'post', 'put', 'delete', 'update', 'patch', 'options', 'head');

    /**
     * @param string $method
     * @return bool
     */
    final public static function contains(string $method): bool {
        return in_array(strtolower($method), self::ALLOWED_METHODS);
    }
}
