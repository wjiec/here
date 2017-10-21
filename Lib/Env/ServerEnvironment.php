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
