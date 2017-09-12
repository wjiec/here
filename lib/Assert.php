<?php
/**
 * Assert.php
 *
 * @package   Here\Lib
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib;
use Here\Lib\Exceptions\AssertError;
use Here\Lib\Exceptions\ExceptionBase;


/**
 * Class Assert
 * @package Here\Lib
 */
final class Assert {
    /**
     * @param mixed $object
     * @param ExceptionBase|null $exception
     */
    final public static function String($object, ExceptionBase $exception = null) {
        if (!is_string($object)) {
            self::_throw($exception);
        }
    }

    /**
     * @param mixed $object
     * @param ExceptionBase|null $exception
     */
    final public static function Integer($object, ExceptionBase $exception = null) {
        if (!is_integer($object)) {
            self::_throw($exception);
        }
    }

    final public static function Boolean($object, ExceptionBase $exception = null) {
        if (!is_bool($object)) {
            self::_throw($exception);
        }
    }

    /**
     * @param $expression
     * @param ExceptionBase|null $exception
     */
    final public static function True($expression, ExceptionBase $exception = null) {
        if ($expression !== true) {
            self::_throw($exception);
        }
    }

    /**
     * @param $expression
     * @param ExceptionBase|null $exception
     */
    final public static function False($expression, ExceptionBase $exception = null) {
        self::True(!$expression, $exception);
    }

    /**
     * @param string $path
     * @param ExceptionBase|null $exception
     */
    final public static function Directory($path, ExceptionBase $exception = null) {
        self::String($path);
        if (!is_dir($path)) {
            self::_throw($exception);
        }
    }

    /**
     * @param string $path
     * @param ExceptionBase|null $exception
     */
    final public static function File($path, ExceptionBase $exception = null) {
        self::String($path);
        if (!is_file($path)) {
            self::_throw($exception);
        }
    }

    /**
     * @param ExceptionBase $exception
     * @throws AssertError|ExceptionBase|null
     */
    final private static function _throw(ExceptionBase $exception = null) {
        if ($exception === null) {
            $exception = new AssertError("Assert error");
        }
        throw $exception;
    }
}
