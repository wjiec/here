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


/**
 * Class Toolkit
 * @package Here\Lib
 */
class Toolkit {
    /**
     * @param $length
     * @return bool|string
     */
    public static function random_string($length) {
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
    public static function get_backtrace($top = -1, $ignore_args = true) {
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
     * @var string
     */
    private static $_characters = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
}
