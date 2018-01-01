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
namespace Here\Lib\Router\Collector\DefaultRouter;
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
     * @addUrl /
     * @addUrl /index[:\.(html|php)?]
     */
    final public function index(RouterRequest $request, RouterResponse $response): void {
        var_dump($request, $response);
    }

    /**
     * @param RouterRequest $request
     * @param RouterResponse $response
     *
     * @routerChannel
     * @addLogger DashBoard
     * @addMethods GET
     * @addUrl /&dashboard
     * @addUrl /&dashboard/{path:RS2}
     * @addMiddleware authorization
     *
     * @TODO `manager` form admin user setting
     */
    final public function dashboard(RouterRequest $request, RouterResponse $response): void {
        var_dump($request, $response);
    }

    /**
     * @param RouterRequest $request
     * @param RouterResponse $response
     *
     * @routerChannel
     * @addMethods GET
     * @addUrl /article/<article_title:[\w\-]+>
     */
    final public function article(RouterRequest $request, RouterResponse $response): void {
        var_dump($request, $response);
    }

    /**
     * @param RouterRequest $request
     * @param RouterResponse $response
     *
     * @routerChannel
     * @addMethods GET, POST
     * @addUrl /user/profile/[user_id:\d+]
     */
    final public function user_profile(RouterRequest $request, RouterResponse $response): void {
        var_dump($request, $response);
    }

    /**
     * @param RouterRequest $request
     * @param RouterResponse $response
     *
     * @routerChannel
     * @addMethods GET
     * @addUrl /static/<theme_name:\w+>/{resource_path:R}
     */
    final public function resources(RouterRequest $request, RouterResponse $response): void {
        var_dump($request, $response);
    }

    /**
     * @param RouterRequest $request
     * @param RouterResponse $response
     *
     * @routerChannel
     * @addMethods GET
     * @addUrl /<core>/<module:\w+>/<action:[a-zA-Z]+>
     */
    final public function test_router_1(RouterRequest $request, RouterResponse $response): void {
        var_dump($request, $response);
    }

    /**
     * @param RouterRequest $request
     * @param RouterResponse $response
     *
     * @routerChannel
     * @addMethods GET
     * @addUrl /<core>/<module:\w+>/<action_id:\d+>
     */
    final public function test_router_2(RouterRequest $request, RouterResponse $response): void {
        var_dump($request, $response);
    }

}
