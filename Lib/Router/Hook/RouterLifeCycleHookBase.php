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
    public static function on_request_enter(): void {
        // @TODO request filter
    }

    /**
     * @inheritdoc
     */
    public static function on_response_leave(): void {
        // @TODO logger
    }

    /**
     * @inheritdoc
     */
    public static function on_request_error(): void {
        // @TODO error logger
    }
}
