<?php
/**
 * UserEnvironment.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Env;


/**
 * Class UserEnvironment
 * @package Here\Env
 */
trait UserEnvironment {
    /**
     * @var array
     */
    private static $_user_env = array();

    /**
     * @param string $name
     * @param null|string $default
     * @return mixed
     */
    final public static function get_user_env(string $name, ?string $default = null) {
        return self::$_user_env[$name] ?? $default;
    }

    /**
     * @param string $name
     * @param string $value
     * @param bool $override
     * @throws EnvironmentOverrideError
     */
    final public static function set_user_env(string $name, string $value, bool $override = true): void {
        if (!$override && isset(self::$_user_env[$name])) {
            throw new EnvironmentOverrideError("cannot override {$name} environment");
        }
        self::$_user_env[$name] = $value;
    }
}
