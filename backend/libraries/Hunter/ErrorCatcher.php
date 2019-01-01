<?php
/**
 * ErrorCatcher.php
 *
 * @package   Here
 * @author    Jayson Wang <jayson@laboys.org>
 * @copyright Copyright (C) 2016-2018 Jayson Wang
 * @license   MIT License
 */
namespace Here\Libraries\Hunter;


use Here\Libraries\Stream\OutputBuffer;
use Here\Plugins\AppLoggerProvider;


/**
 * Class ErrorCatcher
 * @package App\Libraries
 */
final class ErrorCatcher {

    /**
     * @var array|callable[]
     */
    private static $listeners = array();

    /**
     * prepare error catcher
     */
    final public static function prepare() {
        // global exception handler
        set_exception_handler(function(\Throwable $exception) {
            self::exceptionHandler($exception);
        });

        // error handler
        set_error_handler(function(...$args) {
            self::errorHandler(...$args);
        });

        // The following error types cannot be handled with a user defined function:
        //   E_ERROR, E_PARSE, E_CORE_ERROR, E_CORE_WARNING, E_COMPILE_ERROR, E_COMPILE_WARNING
        register_shutdown_function(function (): void {
            $last_error = error_get_last();
            if ($last_error && $last_error['type'] === ($last_error['type'] & self::FATAL_ERROR_VALUE)) {
                // clean "Fatal Error: ..." output
                OutputBuffer::clean_buffer();

                // key information
                $error_code = $last_error['type'];
                $error = $last_error['message'];
                $error_file = $last_error['file'];
                $error_line = $last_error['line'];

                // handler
                self::errorHandler($error_code, $error, $error_file, $error_line, $last_error);
            }
        });
    }

    /**
     * registers an error listener that is used to record
     * after an error has occurred
     * @param callable $callback
     */
    final public static function registerListener($callback): void {
        if (is_callable($callback)) {
            self::$listeners[] = $callback;
        }
    }

    /**
     * trigger an exception without broadcasting
     * @param \Throwable $exception
     */
    final public static function triggerException(\Throwable $exception): void {
        self::exceptionHandler($exception, false);
    }

    /**
     * check listeners and trigger it
     * @param string $error
     */
    final private static function triggerListener(string $error): void {
        foreach (self::$listeners as $listener) {
            if (is_callable($listener)) {
                call_user_func($listener, $error);
            }
        }
    }

    /**
     * @param \Throwable $e
     * @param bool $broadcast
     */
    final private static function exceptionHandler(\Throwable $e, bool $broadcast = true): void {
        $error_message = "{$e->getMessage()}\n[STACKTRACE]:\n{$e->getTraceAsString()}\n";
        (new AppLoggerProvider())->getErrorLogger()->alert($error_message);
        // broadcasting when enable
        if ($broadcast) {
            self::triggerListener($e->getMessage());
        }
    }

    /**
     * @param int $code
     * @param string $error
     * @param null|string $file
     * @param int|null $line
     * @param array|null $context
     */
    final private static function errorHandler(int $code, string $error,
                                               ?string $file = null, ?int $line = 0,
                                               ?array $context = null): void {
        $error_message = "In `{$file}` at line `{$line}`: [ {$code}:{$error} ]\n[STACKTRACE]:\n%s\n\n%s\n";
        (new AppLoggerProvider())->getErrorLogger()->error(
            sprintf($error_message, self::getStackTrace(), json_encode($context)));
        self::triggerListener($error);
    }

    /**
     * @return string
     */
    final private static function getStackTrace(): string {
        $trace_string = '';
        foreach (new StackTrace() as $stack) {
            $trace_string .= sprintf("#%d [ %s:%s ] <----> %s%s%s(%s);\n", ...array(
                $stack[StackTrace::STACK_TRACE_CALLED_INDEX],
                $stack[StackTrace::STACK_TRACE_CALLED_AT],
                $stack[StackTrace::STACK_TRACE_CALLED_LINE],
                $stack[StackTrace::STACK_TRACE_CLASS_NAME],
                $stack[StackTrace::STACK_TRACE_CALL_OPERATOR],
                $stack[StackTrace::STACK_TRACE_FUNCTION_NAME],
                self::stringify_arguments(...$stack[StackTrace::STACK_TRACE_ARGUMENTS])
            ));
        }
        return $trace_string;
    }

    /**
     * @param $arguments
     * @return string
     */
    final private static function stringify_arguments(...$arguments): string {
        $result = array();
        foreach ($arguments as $argument) {
            if (is_array($argument)) {
                $result[] = 'array(' . join(',', array_map(function($v) {
                    return self::stringify_arguments($v);
                }, $argument)) . ')';
            } else if (is_string($argument)) {
                $result[] = "'{$argument}'";
            } else if (is_integer($argument) || is_float($argument)) {
                $result[] = strval($argument);
            } else if (is_object($argument)) {
                $result[] = get_class($argument);
            } else if (is_null($argument)) {
                $result[] = 'null';
            } else {
                $result[] = 'UNKNOWN';
            }
        }
        return join(',', $result);
    }

    /**
     * fatal error value set
     */
    private const FATAL_ERROR_VALUE = E_CORE_ERROR | E_COMPILE_ERROR | E_RECOVERABLE_ERROR | E_PARSE | /* Fatal */1;

}
