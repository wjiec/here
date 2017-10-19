<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 10/20/2017
 * Time: 10:01
 */
namespace Here\Lib\Env;


/**
 * Class ServerEnvironment
 * @package Here\Env
 */
trait ServerEnvironment {
    /**
     * @var array
     */
    private static $_server_envs = array();

    /**
     * @param string $name
     * @param null|string $default
     * @return string|null
     */
    final public static function get_server_env(string $name, ?string $default = null) {
        if (empty(self::$_server_envs)) {
            foreach ($_SERVER as $key => $val) {
                self::$_server_envs[strtolower($key)] = $val;
            }
        }

        return self::$_server_envs[strtolower($name)] ?? $default;
    }

    /**
     * @return array
     */
    final public static function get_server_envs(): array {
        self::get_server_env('mixed');
        return self::$_server_envs;
    }
}
