<?php
/**
 * DefaultChannel.php
 *
 * @package   here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector\Channel;
use Here\Lib\Router\RouterRequest;
use Here\Lib\Router\RouterResponse;


/**
 * Trait DefaultChannel
 * @package Here\Lib\Router\Collector\Channel
 */
trait DefaultChannel {
    /**
     * @param RouterRequest $request
     * @param RouterResponse $response
     *
     * @routerChannel
     * @addMethods GET
     * @addUrl /[:index\.html|php]
     */
    final public function index(RouterRequest $request, RouterResponse $response): void {
        var_dump($request, $response);
    }

    /**
     * @param RouterRequest $request
     * @param RouterResponse $response
     *
     *
     * @routerChannel
     * @addLogger
     * @addMethods GET
     * @addUrl /manager[/<...>]
     * @addMiddleware authorization
     *
     * @TODO `manager` form admin user setting
     */
    final public function manager(RouterRequest $request, RouterResponse $response): void {
        var_dump($request, $response);
    }

    /**
     * @param RouterRequest $request
     * @param RouterResponse $response
     */
    final public function article(RouterRequest $request, RouterResponse $response): void {
        var_dump($request, $response);
    }

    /**
     * @param RouterRequest $request
     * @param RouterResponse $response
     */
    final public function resources(RouterRequest $request, RouterResponse $response): void {
        var_dump($request, $response);
    }
}
