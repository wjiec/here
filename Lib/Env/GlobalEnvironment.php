<?php
/**
 * GlobalEnvironment.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Env;


/**
 * Class GlobalEnvironment
 * @package Here\Env
 */
final class GlobalEnvironment {
    /**
     * predefined environment variables
     */
    use ServerEnvironment;

    /**
     * custom environment variables
     */
    use UserEnvironment;

    /**
     * @param string $name
     * @param string|null $default
     * @return mixed
     */
    final public static function get_env(string $name, ?string $default = null) {
        $server_env = self::get_server_env($name, $default);
        $user_env = self::get_user_env($name, $default);

        // not found
        if ($server_env === $default && $server_env === $user_env) {
            return $default;
        }

        // exists on server_env and user_env
        if ($server_env !== $default && $user_env !== $default) {
            return $user_env;
        }

        return $server_env === $default ? $user_env : $server_env;
    }
}
