<?php
/**
 * Toolkit.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib;
use Here\Lib\Exceptions\AssertError;


/**
 * Class Toolkit
 * @package Here\Lib
 */
class Toolkit {
    /**
     * @param $length
     * @return bool|string
     */
    final public static function random_string($length) {
        Assert::Integer($length);

        if ($length < strlen(self::$_characters)) {
            return substr(str_shuffle(self::$_characters), 0, $length);
        } else {
            $result_string = '';

            // build random string
            while (strlen($result_string) < $length) {
                $result_string = str_shuffle($result_string . str_shuffle(self::$_characters));
            }

            return substr($result_string, 0, $length);
        }
    }

    /**
     * @param int $top
     * @param bool $ignore_args
     * @return array
     */
    final public static function get_backtrace($top = -1, $ignore_args = true) {
        Assert::Integer($top);
        Assert::Boolean($ignore_args);

        $option = DEBUG_BACKTRACE_PROVIDE_OBJECT;
        if ($ignore_args === true) {
            $option |= DEBUG_BACKTRACE_IGNORE_ARGS;
        }

        // get backtrace
        $backtrace = debug_backtrace($option);
        // shift useless top backtrace
        while ($top != 1) {
            array_shift($backtrace);
            $top += 1;
        }
        return $backtrace;
    }

    /**
     * @param mixed $object
     * @return string
     */
    final public static function to_string($object) {
        try {
            Assert::String($object);
            return $object;
        } catch (AssertError $e) {
            return strval($object);
        }
    }

    /**
     * @param mixed $object
     * @return int
     */
    final public static function to_integer($object) {
        try {
            Assert::Integer($object);
            return $object;
        } catch (AssertError $e) {
            return intval($object);
        }
    }

    /**
     * @var string
     */
    private static $_characters = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
}
