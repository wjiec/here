<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 10/10/2017
 * Time: 15:40
 */
namespace Here\Lib\Router;
use Here\Lib\Assert;

/**
 * Class AllowedMethods
 * @package Here\Lib\Router
 */
final class AllowedMethods {
    /**
     *
     */
    const ALLOWED_METHODS = array('get', 'post', 'put', 'delete', 'update', 'patch', 'options', 'head');

    /**
     * @param string $method
     * @return bool
     */
    final public static function check($method) {
        Assert::String($method);

        return in_array(strtolower($method), self::ALLOWED_METHODS);
    }
}
