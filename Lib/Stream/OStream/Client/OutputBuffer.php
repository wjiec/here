<?php
/**
 * OutputBuffer.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Stream\OStream\Client;
use Here\Config\Constant\SysConstant;
use Here\Config\Constant\SysEnvironment;
use Here\Lib\Environment\EnvironmentOverrideError;
use Here\Lib\Environment\GlobalEnvironment;
use Here\Lib\Extension\Callback\CallbackObject;
use Here\Lib\Utils\Filter\Validator\TrueValidator;


/**
 * Class OutputBuffer
 * @package Here\Lib\Stream\OStream\Client
 */
final class OutputBuffer {
    /**
     * @param CallbackObject|null $callback
     */
    final public static function startup(?CallbackObject $callback = null): void {
        /* startup output buffer */
        ob_start(function(string $buffer, int $phase) use ($callback) : string {
            // when buffer is turned off
            if (
                $phase & PHP_OUTPUT_HANDLER_FINAL
                || $phase & PHP_OUTPUT_HANDLER_FLUSH
                || $phase & PHP_OUTPUT_HANDLER_WRITE
            ) {
                if (TrueValidator::filter(GlobalEnvironment::get_user_env(SysEnvironment::ENV_COMMIT_STATUS))) {
                    return $callback ? $callback->apply($buffer) : $buffer;
                }

                throw new OutputBufferError("please commit response by `Response::commit()`");
            }

            GlobalEnvironment::set_user_env(SysEnvironment::ENV_COMMIT_STATUS, 'off');
            return '';
        });
    }

    /**
     * @return string
     */
    final public static function clean_buffer(): string {
        // why not `ob_get_clean` ?
        // the function also "turns off output buffering", not just cleans it.
        if (ob_get_level() === 0) {
            self::startup();
        }

        $contents = ob_get_contents();
        ob_clean();

        return $contents;
    }

    /**
     * close output buffer and output it
     */
    final public static function commit_buffer(): void {
        try {
            GlobalEnvironment::set_user_env(SysEnvironment::ENV_COMMIT_STATUS, 'yes');
        } catch (EnvironmentOverrideError $e) {}
        ob_end_flush();
    }
}
