<?php
/**
 * Here Utility Tools Class
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */


/**
 * Class Here_Utils
 */
class Here_Utils {
    /**
     * @param string $name
     * @param mixed $object
     * @param string $except_type
     * @param string $source
     * @throws Here_Exceptions_ParameterError
     */
    public static function check_type($name, $object, $except_type, $source) {
        // validator
        $function = "is_{$except_type}";
        // check function exists
        if (function_exists($function)) {
            // check object type
            if (!call_user_func($function, $object)) {
                throw new Here_Exceptions_ParameterError("{$name} except {$except_type} type, got " . gettype($object),
                    $source);
            }
        } else {
            throw new Here_Exceptions_ParameterError("except type invalid",
                'Here:Here_Utils:check_type');
        }
    }

    /**
     * entry account password
     *
     * @param string $password
     * @throws Here_Exceptions_FatalError
     * @return string
     */
    public static function account_password_encrypt($password) {
        // using password_hash(default: bcrypt)
        $encrypt_password = password_hash($password, PASSWORD_DEFAULT);
        // check encrypt state
        if ($encrypt_password === false) {
            throw new Here_Exceptions_FatalError('password_hash fail',
                'Here:Utils:account_password_encrypt');
        }
        // return encrypt password
        return $encrypt_password;
    }

    /**
     * verify password is correct
     *
     * @param string $password
     * @param string $encrypt_password
     * @return bool
     */
    public static function account_password_verify($password, $encrypt_password) {
        return password_verify($password, $encrypt_password);
    }
}
