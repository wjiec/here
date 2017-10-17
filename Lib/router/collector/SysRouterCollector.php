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
use Here\Lib\Router\RouterMatch;


/**
 * Class SysRouterCollector
 * @package Here\Lib\Router\Collector
 */
class SysRouterCollector extends RouterCollector {
    /**
     * @param RouterMatch $m
     *
     * @addMethods GET
     * @addUrl [/index][:\.html?|php]
     */
    final public function index_router(RouterMatch $m) {
        var_dump($m);
    }

    /**
     * @param RouterMatch $m
     *
     * @addMethods GET
     * @addUrl /static/<...>
     */
    final public function resource_router(RouterMatch $m) {
        var_dump($m);
    }
}
