<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 10/20/2017
 * Time: 10:13
 */
namespace Here\Lib\Env;


/**
 * Class GlobalEnvironment
 * @package Here\Env
 */
final class GlobalEnvironment {
    use ServerEnvironment;
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
