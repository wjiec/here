<?php
/**
 * RouterType.php
 *
 * @package   here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector;
use Here\Lib\Ext\Enum\EnumType;


/**
 * Class RouterType
 * @package Here\Lib\Router\Collector\Generator
 */
final class RouterType extends EnumType {
    /**
     * default is ROUTER_TYPE_CHANNEL
     */
    public const __default = self::ROUTER_TYPE_UNKNOWN;

    /**
     * router type: channel
     */
    public const ROUTER_TYPE_UNKNOWN = '';

    /**
     * router type: channel
     */
    public const ROUTER_TYPE_CHANNEL = 'routerChannel';

    /**
     * router type: middleware
     */
    public const ROUTER_TYPE_MIDDLEWARE = 'routerMiddleware';

    /**
     * router type: handler
     */
    public const ROUTER_TYPE_HANDLER = 'routerHandler';
}
