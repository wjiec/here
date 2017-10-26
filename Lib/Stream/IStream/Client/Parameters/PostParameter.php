<?php
/**
 * Created by PhpStorm.
 * User: ShadowMan
 * Date: 2017/10/26
 * Time: 22:10
 */
namespace Here\Lib\Stream\IStream\Client\Parameters;


/**
 * Trait PostRequest
 * @package Here\Stream\IStream\Client
 */
trait PostParameter {
    /**
     * @var array
     */
    private static $_post_parameters;

    /**
     * @var array
     */
    private static $_additional_post_parameters = array();

    /**
     * @param string $name
     * @param null|string $default
     * @return null|string
     */
    final public static function post_param(string $name, ?string $default = null) {
        if (self::$_post_parameters === null) {
            self::$_post_parameters = $_POST;
            $_POST = array();
        }

        return self::$_post_parameters[$name]
            ?? self::$_additional_post_parameters[$name]
                ?? $default;
    }

    /**
     * @param string $name
     * @param string $val
     * @param bool $override
     * @throws ParameterOverrideError
     */
    final public static function add_post_param(string $name, string $val, bool $override = true): void {
        if (!$override && isset(self::$_additional_post_parameters[$name])) {
            throw new ParameterOverrideError("cannot override '{$name}' post parameter'");
        }

        self::$_additional_post_parameters[$name] = $val;
    }
}
