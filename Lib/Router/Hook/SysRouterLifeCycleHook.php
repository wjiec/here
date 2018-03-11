<?php
/**
 * SysRouterLifeCycleHook.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Hook;
use Here\Lib\Router\Interceptor\RouterInterceptor;
use Here\Lib\Stream\OStream\Client\Response;


/**
 * Class SysRouterLifeCycleHook
 * @package Here\Lib\Router\Hook
 */
final class SysRouterLifeCycleHook extends RouterLifeCycleHookBase {
    /**
     * @inheritdoc
     */
    final public static function on_request_enter(): void {
        // reject robot request
        RouterInterceptor::reject_robot();
    }

    /**
     * @inheritdoc
     */
    final public static function on_response_leave(): void {
        Response::commit();
    }
}
