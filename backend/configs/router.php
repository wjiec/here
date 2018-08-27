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


    // create session
    $router->add('/session', array(
        'controller' => 'session',
        'action' => 'create'
    ))->via('PUT');

    // get backend status
    $router->add('/init', array(
        'controller' => 'frontend',
        'action' => 'init'
    ))->via('GET');


    return $router;
});
