<?php
/**
 * GetRequest.php
 *
 * @package   here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Stream\IStream\Client\Parameters;


/**
 * Trait GetRequest
 * @package Here\Stream\IStream\Client
 */
trait GetParameter {
    /**
     * @var array
     */
    private static $_get_parameters;

    /**
     * @var array
     */
    private static $_additional_get_parameters = array();

    /**
     * @param string $name
     * @param null|string $default
     * @return null|string
     */
    final public static function url_param(string $name, ?string $default = null) {
        // initial/reset state
        if (self::$_get_parameters === null) {
            self::$_get_parameters = $_GET;
            $_GET = array();
        }

        return self::$_get_parameters[$name]
            ?? self::$_additional_get_parameters[$name]
                ?? $default;
    }

    /**
     * @param string $name
     * @param string $val
     * @param bool $override
     * @throws ParameterOverrideError
     */
    final public static function add_url_param(string $name, string $val, bool $override = true): void {
        if (!$override && isset(self::$_additional_get_parameters[$name])) {
            throw new ParameterOverrideError("cannot override '{$name}' url parameter");
        }

        self::$_additional_get_parameters[$name] = $val;
    }
}
