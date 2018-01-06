<?php
/**
 * RouterLifeCycleHookBase.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Hook;


/**
 * Class RouterLifeCycleHook
 * @package Here\Lib\Router\Hook
 */
abstract class RouterLifeCycleHookBase implements RouterLifeCycleHookInterface {
    /**
     * @inheritdoc
     */
    public static function on_request_enter(): void {}

    /**
     * @inheritdoc
     */
    public static function on_request_dispatch_start(): void {}

    /**
     * @inheritdoc
     */
    public static function on_middleware_start(): void {}

    /**
     * @inheritdoc
     */
    public static function on_callback_start(): void {}

    /**
     * @inheritdoc
     */
    public static function on_callback_end(): void {}

    /**
     * @inheritdoc
     * @param int $error_code
     * @param string $error_message
     */
    public static function on_error_occurs(int $error_code, string $error_message): void {}
}
