<?php
/**
 * GlobalExceptionHandler.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Exceptions;
use Here\Lib\Extension\Callback\CallbackObject;
use Here\Lib\Stream\OStream\Client\OutputBuffer;


/**
 * Class GlobalExceptionHandler
 * @package Here\Lib\Exceptions
 */
final class GlobalExceptionHandler {
    /**
     * @var array
     */
    private static $_exception_listeners = array();

    /**
     * global exception handler
     */
    final public static function error_trapping(): void {
        // global exception handler
        set_exception_handler(function(\Throwable $except): void {
            self::exception_handler($except);
        });

        // error handler
        set_error_handler(function(int $errno, string $message, ?string $file, int $line, array $context): bool {
            return self::error_handler($errno, $message, $file, $line, $context);
        });

        // The following error types cannot be handled with a user defined function:
        //   E_ERROR, E_PARSE, E_CORE_ERROR, E_CORE_WARNING, E_COMPILE_ERROR, E_COMPILE_WARNING
        register_shutdown_function(function (): void {
            $last_error = error_get_last();

            if ($last_error && $last_error['type'] === ($last_error['type'] & self::FATAL_ERROR_VALUE)) {
                // clean "Fatal Error: ..." output
                OutputBuffer::clean_buffer();

                // key information
                $errno = $last_error['type'];
                $error = $last_error['message'];
                $error_file = $last_error['file'];

                // handler
                self::shutdown_handler($errno, $error, $error_file, $last_error);
            }
        });
    }

    /**
     * @param string $exception_name
     * @param CallbackObject $callback
     */
    final public static function when(string $exception_name, CallbackObject $callback): void {
        if (!isset(self::$_exception_listeners[$exception_name])) {
            self::$_exception_listeners[$exception_name] = array();
        }
        self::$_exception_listeners[$exception_name][] = $callback;
    }

    /**
     * @param \Throwable $except
     * @param bool $skip_listener
     */
    final public static function trigger_exception(\Throwable $except, bool $skip_listener = false): void {
        self::exception_handler($except, $skip_listener);
    }

    /**
     * @param \Throwable $exception
     * @param bool $skip_listener
     */
    final private static function exception_handler(\Throwable $exception, bool $skip_listener = false): void {
        $exception_name = get_class($exception);
        // check current exception has listeners
        if (!$skip_listener && isset(self::$_exception_listeners[$exception_name])) {
            try {
                /* @var CallbackObject $listener */
                foreach (self::$_exception_listeners[$exception_name] as $listener) {
                    // check return value of listener
                    if (!$listener->apply($exception)) {
                        self::trigger_exception($exception, true);
                    }
                }

                /* clear last error */
                error_clear_last();
                OutputBuffer::commit_buffer();
                return;
            } catch (\ArgumentCountError $e) {
                self::trigger_exception($e, true);
            }
        }

        $errno = $exception->getCode();
        $error = $exception->getMessage();
        if ($exception instanceof ExceptionBase) {
            $error = $exception->get_message();
        }
        $file = $exception->getFile();
        $line = $exception->getLine();

        self::global_handler($errno, $error, $file, $line, array($exception));
    }

    /**
     * @param int $errno
     * @param string $msg
     * @param null|string $file
     * @param int|null $line
     * @param array|null $context
     * @return bool
     */
    final private static function error_handler(int $errno, string $msg,
                                                ?string $file, ?int $line,
                                                ?array $context): bool {
        self::global_handler($errno, $msg, $file, $line, $context);
        return true;
    }

    /**
     * php shutdown handler
     *
     * @param int $errno
     * @param string $msg
     * @param null|string $filename
     * @param array|null $context
     */
    final private static function shutdown_handler(int $errno, string $msg, ?string $filename, ?array $context): void {
        self::global_handler($errno, $msg, $filename, $context['line'] ?? null, $context);
    }

    /**
     * @param int $errno
     * @param string $error
     * @param null|string $file
     * @param null|int $line
     * @param array|null $context
     */
    final private static function global_handler(int $errno, string $error,
                                                 ?string $file, ?int $line,
                                                 ?array $context): void {

        // @TODO, default error page or trigger router error?
        OutputBuffer::clean_buffer();
        echo '<pre>';

        var_dump($errno);
        var_dump($error);
        var_dump($file);
        var_dump($line);
        var_dump($context);

        echo '</pre>';
        OutputBuffer::commit_buffer();
    }

    /**
     * fatal error value set
     */
    private const FATAL_ERROR_VALUE = E_CORE_ERROR | E_COMPILE_ERROR | E_RECOVERABLE_ERROR | E_PARSE | /* Fatal */1;
}
