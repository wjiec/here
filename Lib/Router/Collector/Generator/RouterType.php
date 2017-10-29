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
namespace Here\Lib\Router\Collector\Generator;


use Here\Lib\Ext\Enum\Enum;

/**
 * Class RouterType
 * @package Here\Lib\Router\Collector\Generator
 */
final class RouterType extends Enum {
    /**
     * default is ROUTER_TYPE_CHANNEL
     */
    public const __default = self::ROUTER_TYPE_CHANNEL;

    /**
     * router type: channel
     */
    public const ROUTER_TYPE_CHANNEL = 0x0000;

    /**
     * router type: middleware
     */
    public const ROUTER_TYPE_MIDDLEWARE = 0x0001;
}
