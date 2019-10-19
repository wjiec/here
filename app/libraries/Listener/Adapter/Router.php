<?php
/**
 * here application
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.org>
 * @copyright Copyright (C) 2016-2019 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/nosjay/here
 */
namespace Here\Libraries\Listener\Adapter;

use Here\Libraries\Listener\AbstractListener;
use Phalcon\Events\Event;
use Phalcon\Mvc\Router as MvcRouter;
use Phalcon\Mvc\Router\Route;


/**
 * Class Router
 * @package Here\Libraries\Listener\Adapter
 */
final class Router extends AbstractListener {

    /**
     * Any route is not matched
     *
     * @param Event $event
     * @param MvcRouter $router
     * @param Route $route
     */
    final public function notMatchedRoute(Event $event, MvcRouter $router, Route $route) {
        /* @TODO forward to module error page */
    }

}
