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
     * process on response will send
     */
    public static function on_response_leave(): void;
}
