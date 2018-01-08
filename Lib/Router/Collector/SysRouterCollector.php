<?php
/**
 * SysRouterCollector.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector;
use Here\Lib\Router\Collector\DefaultRouter\DefaultChannel;
use Here\Lib\Router\Collector\DefaultRouter\DefaultHandler;
use Here\Lib\Router\Collector\DefaultRouter\DefaultMiddleware;


/**
 * Class SysRouterCollector
 * @package Here\Lib\Router\Collector
 */
abstract class SysRouterCollector extends RouterCollector {
    /**
     * default middleware
     */
    use DefaultMiddleware;

    /**
     * default channel
     */
    use DefaultChannel;

    /**
     * default handler
     */
    use DefaultHandler;
}
