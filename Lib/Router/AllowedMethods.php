<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 10/10/2017
 * Time: 15:40
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
