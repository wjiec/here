<?php
/**
 * ServerEnvironment.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Environment;


/**
 * Class ServerEnvironment
 * @package Here\Environment
 */
trait ServerEnvironment {
    /**
     * @var array
     */
    private static $_server_env = array();

    /**
     * @param string $name
     * @param null|string $default
     * @return string|null
     */
    final public static function get_server_env(string $name, ?string $default = null) {
        if (empty(self::$_server_env)) {
            foreach ($_SERVER as $key => $val) {
                self::$_server_env[strtolower($key)] = $val;
            }
        }

        return self::$_server_env[strtolower($name)] ?? $default;
    }
}
