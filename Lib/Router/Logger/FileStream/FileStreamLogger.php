<?php
/**
 * FileStreamLogger.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Logger\FileStream;
use Here\Lib\Router\Logger\LoggerBase;


/**
 * Class FileStreamLogger
 * @package Here\Lib\Router\Logger
 */
final class FileStreamLogger extends LoggerBase {
    /**
     * @return bool
     */
    final public static function available(): bool {
        return true;
    }

    /**
     * @param string $name
     * @param string $message
     */
    final public static function log(string $name, string $message): void {
        // TODO: Implement log() method.
    }
}
