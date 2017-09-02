<?php
/**
 * Environment.php
 *
 * @package   Here\Lib
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib;


use Here\Lib\Exceptions\EnvOverrideError;

class Environment {
    /**
     * @var array
     */
    private static $_env = array();

    /**
     * @var array
     */
    private static $_server_env = array();

    /**
     * @param string $name
     * @param mixed $value
     * @param bool $override
     * @throws EnvOverrideError
     */
    final public static function set_env($name, $value, $override = true) {
        Assert::String($name);

        if ($override === false) {
            if (array_key_exists($name, self::$_env)) {
                throw new EnvOverrideError("cannot override {$name}");
            }
        }
        self::$_env[$name] = $value;
    }

    /**
     * @param string $name
     * @param null $default
     * @return mixed|null
     */
    final public static function get_env($name, $default = null) {
        if (array_key_exists($name, self::$_env)) {
            return self::$_env[$name];
        }
        return $default;
    }

    /**
     * @param string $name
     * @param null $default
     * @return mixed|null
     */
    final public static function get_server_env($name, $default = null) {
        if (empty(self::$_server_env)) {
            foreach ($_SERVER as $key => $val) {
                self::$_server_env[strtolower($key)] = $val;
            }
        }

        $name = strtolower($name);
        if (array_key_exists($name, self::$_server_env)) {
            return self::$_server_env[$name];
        }
        return $default;
    }
}
