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
use Here\Lib\Router\Collector\Channel\DefaultChannel;
use Here\Lib\Router\Collector\Middleware\DefaultMiddleware;


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
     * loaded default channel
     */
    use DefaultChannel;
}
