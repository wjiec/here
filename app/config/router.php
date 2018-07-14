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


/* @var Router $router */
$router = Di::getDefault()->get('router');
$router->setDefaultNamespace('Here\Controllers');

/* route the incoming request */
$router->handle();
