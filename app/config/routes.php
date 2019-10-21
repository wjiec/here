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
use Phalcon\Mvc\Router;
use Phalcon\Mvc\Router\Group as RouteGroup;


$router = new Router(false);

/**
 * Admin group
 */
$group = (new RouteGroup(array('module' => 'admin')))->setPrefix(env('ADMIN_PREFIX', '/admin'));
// Shows the states of blog to administrator
$group->add('[/]{0,1}(dashboard){0,1}', array('controller' => 'dashboard', 'action' => 'index'))
    ->setName('Dashboard');
$router->mount($group);

return $router;
