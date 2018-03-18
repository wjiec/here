<?php
/**
 * LogLevel.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Logger;


use Here\Lib\Extension\Enum\EnumType;

/**
 * Class LogLevel
 * @package Here\Lib\Logger
 */
final class LogLevel extends EnumType {
    /**
     * System is unusable.
     */
    public const EMERGENCY = 'emergency';

    /**
     * Action must be taken immediately.
     */
    public const ALERT     = 'alert';

    /**
     * Critical conditions.
     */
    public const CRITICAL  = 'critical';

    /**
     * Runtime errors that do not require immediate action but should typically
     * be logged and monitored.
     */
    public const ERROR     = 'error';

    /**
     * Exceptional occurrences that are not errors.
     */
    public const WARNING   = 'warning';

    /**
     * Normal but significant events.
     */
    public const NOTICE    = 'notice';

    /**
     * Interesting events.
     */
    public const INFO      = 'info';

    /**
     * Detailed debug information.
     */
    public const DEBUG     = 'debug';
}
