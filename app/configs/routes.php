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


$router = new Router(false);

/**
 * Homepage
 */
$router->add('/', array(
    'module' => 'stage',
    'controller' => 'discussions',
    'action' => 'index'
))->setName('discussions-index');

/**
 * Admin group
 */
$admin_prefix = env('ADMIN_PREFIX', 'admin');
$router->add("/{$admin_prefix}/:controller/:action/:params", array(
    'module' => 'admin',
    'controller' => 1,
    'action' => 2,
    'params' => 3
));

return $router;
