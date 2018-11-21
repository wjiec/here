<?php
/**
 * OutputBuffer.php
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.org>
 * @copyright Copyright (C) 2016-2018 Jayson Wang
 * @license   MIT License
 */
namespace Here\Libraries\Stream;


/**
 * Class OutputBuffer
 * @package Here\Libraries\Stream
 */
final class OutputBuffer {

    /**
     * @param callable|null $callback
     */
    final public static function startup($callback = null): void {
        /* startup output buffer */
        ob_start(function(string $buffer, int $phase) use ($callback) : string {
            // when buffer is turned off
            if ($phase & PHP_OUTPUT_HANDLER_FINAL ||
                $phase & PHP_OUTPUT_HANDLER_FLUSH ||
                $phase & PHP_OUTPUT_HANDLER_WRITE
            ) {
                if (is_callable($callback)) {
                    return call_user_func($callback, $buffer);
                }
                return $buffer;
            }
            return '';
        });
    }

    /**
     * @return string
     */
    final public static function clean_buffer(): string {
        // why not `ob_get_clean` ?
        // the function also "turns off output buffering", not just cleans it.
        $contents = ob_get_contents();
        ob_clean();
        return $contents;
    }

}
