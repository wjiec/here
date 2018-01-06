<?php
/**
 * RouterLifeCycleHookInterface.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Hook;


/**
 * Interface RouterLifeCycleHookInterface
 * @package Here\Lib\Router\Hook
 */
interface RouterLifeCycleHookInterface {
    /**
     * process on request has received
     */
    public static function on_request_enter(): void;

    /**
     * on request dispatch start
     */
    public static function on_request_dispatch_start(): void;

    /**
     * request dispatch end and middleware start(if exists)
     */
    public static function on_middleware_start(): void;

    /**
     * middleware over and callback start
     */
    public static function on_callback_start(): void;

    /**
     * on callback end
     */
    public static function on_callback_end(): void;

    /**
     * @param int $error_code
     * @param string $error_message
     */
    public static function on_error_occurs(int $error_code, string $error_message): void;
}
