<?php
/**
 * route definition in here
 *
 * @package   Here
 * @author    Jayson Wang <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 Jayson Wang
 */
namespace Here\Config;


use Phalcon\Di;
use Phalcon\Mvc\Router;


/* dependency management */
$di = Di::getDefault();

/* @var Router $router */
$di->setShared('router', function() {
    /* create an router and using custom route table */
    $router = new Router(false);

    /* index action */
    $router->add('/((index)?(\.\w+)?)', array(
        'module' => 'frontend',
        'controller' => 'index',
        'action' => 'index'
    ))->via(array('GET'));

    /* login action */
    $router->add('/login', array(
        'module' => 'backend',
        'controller' => 'session',
        'action' => 'login'
    ))->via('POST');

    return $router;
});
