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
        }
    }
}
