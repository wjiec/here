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
use Here\Lib\Utils\Interfaces\InitializerInterface;
use Here\Lib\Stream\OStream\Client\Response;


/**
 * Class GlobalExceptionHandler
 * @package Here\Lib\Exceptions
 */
final class GlobalExceptionHandler implements InitializerInterface {
    /**
     * global exception handler
     */
    final public static function init(): void {
        // global exception handler
        set_exception_handler(function(\Throwable $except): void {
            self::_exception_handler($except);
        });

        // error handler
        set_error_handler(function(int $errno, string $message, ?string $file, int $line, array $context): bool {
            return self::_error_handler($errno, $message, $file, $line, $context);
        });

        // The following error types cannot be handled with a user defined function:
        //  E_ERROR, E_PARSE, E_CORE_ERROR, E_CORE_WARNING, E_COMPILE_ERROR, E_COMPILE_WARNING
        register_shutdown_function(function (): void {
            $last_error = error_get_last();

            if ($last_error && $last_error['type'] === $last_error['type'] & self::FATAL_ERROR_VALUE) {
                // clean "Fatal Error: ..." output
                Response::clean_response();

                // key information
                $errno = $last_error['type'];
                $error = $last_error['message'];
                $error_file = $last_error['file'];

                // handler
                self::_shutdown_handler($errno, $error, $error_file, $last_error);
            }
        });
    }

    /**
     * @param \Throwable $except
     */
    final public static function trigger_exception(\Throwable $except): void {
        self::_exception_handler($except);
    }

    /**
     * @param \Throwable $exception
     */
    final private static function _exception_handler(\Throwable $exception): void {
        $errno = $exception->getCode();
        $error = $exception->getMessage();
        if ($exception instanceof ExceptionBase) {
            $error = $exception->get_message();
        }
        $file = $exception->getFile();
        $line = $exception->getLine();

        self::_global_handler($errno, $error, $file, $line, array($exception));
    }

    /**
     * @param int $errno
     * @param string $msg
     * @param null|string $file
     * @param int|null $line
     * @param array|null $context
     * @return bool
     */
    final private static function _error_handler(int $errno, string $msg,
                                                 ?string $file, ?int $line,
                                                 ?array $context): bool {
        self::_global_handler($errno, $msg, $file, $line, $context);
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
    final private static function _shutdown_handler(int $errno, string $msg, ?string $filename, ?array $context): void {
        self::_global_handler($errno, $msg, $filename, $context['line'] ?? null, $context);
    }

    /**
     * @param int $errno
     * @param string $error
     * @param null|string $file
     * @param null|int $line
     * @param array|null $context
     */
    final private static function _global_handler(int $errno, string $error,
                                                  ?string $file, ?int $line,
                                                  ?array $context): void {

        // @TODO, default error page or trigger router error?
        Response::clean_response();
        echo '<pre>';

        var_dump($errno);
        var_dump($error);
        var_dump($file);
        var_dump($line);
        var_dump($context);

        echo '</pre>';

        Response::commit();
    }

    /**
     * fatal error value set
     */
    private const FATAL_ERROR_VALUE = E_CORE_ERROR | E_COMPILE_ERROR | E_RECOVERABLE_ERROR | E_PARSE | /* Fatal */1;
}
