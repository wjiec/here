<?php
/**
 * LoggerInterface.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Logger;


/**
 * Interface LoggerInterface
 * @package Here\Lib\Router\Logger
 */
interface LoggerInterface {
    /**
     * @return bool
     */
    public static function available(): bool;

    /**
     * @param string $name
     * @param string $message
     */
    public static function log(string $name, string $message): void;
}
