<?php
/**
 * LastException.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Exceptions;


/**
 * Class LastException
 * @package Here\Lib\Exceptions
 */
final class LastException {
    /**
     * @var ExceptionBase
     */
    private static $_last_exception;

    /**
     * @param ExceptionBase $exception
     */
    final public static function set_exception(ExceptionBase $exception): void {
        self::$_last_exception = $exception;
    }

    /**
     * @return ExceptionBase
     */
    final public static function get_exception(): ExceptionBase {
        return self::$_last_exception;
    }

    /**
     * @return string
     */
    final public static function get_stack_trace(): string {
        return self::$_last_exception->__toString();
    }
}
