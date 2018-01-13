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
use Here\Lib\Stream\IStream\Client\RequestMethods;


/**
 * Class AllowedMethods
 * @package Here\Lib\Router
 */
final class AllowedMethods {
    /**
     * @param string $method
     * @return bool
     */
    final public static function contains(string $method): bool {
        return in_array(strtolower($method), RequestMethods::get_browser_compatibility_methods());
    }

    /**
     * @param string $method
     * @return string
     */
    final public static function standardize(string $method): string {
        return strtolower($method);
    }
}
