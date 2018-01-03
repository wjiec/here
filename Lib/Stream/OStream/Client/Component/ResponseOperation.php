<?php
/**
 * ResponseOperation.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Stream\OStream\Client\Component;


/**
 * Trait ResponseOperation
 * @package Here\Lib\Stream\OStream\Client\Component
 */
trait ResponseOperation {
    /**
     * init response environments
     */
    final public static function init(): void {
        // start output buffer
        ob_start();
    }

    /**
     * clean output buffer and return
     */
    final public static function clean_contents(): string {
        $contents = ob_get_contents();
        ob_clean();

        return $contents;
    }

    /**
     * commit response to client and exit
     */
    final public static function commit(): void {
        ob_end_clean();
        exit();
    }
}
