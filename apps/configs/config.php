<?php
/**
 * configure for Here
 *
 * @package   Here
 * @author    Jayson Wang <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 Jayson Wang
 */
namespace Here\Config;
use Phalcon\Config;


return new Config(array(
    'database' => array(
        'adapter'     => 'Mysql',
        'host'        => 'mysql',
        'username'    => 'root',
        'password'    => 'root',
        'dbname'      => 'here',
        'charset'     => 'utf8mb4',
    ),
    'redis' => array(
        'adapter'   => 'Redis',
        'host'      => 'redis',
    ),
    'frontend' => array(
        'module_root' => FRONTEND_MODULE_ROOT . '/',
        'controllers_root' => FRONTEND_MODULE_ROOT . '/controllers',
        'models_root' => FRONTEND_MODULE_ROOT . '/models',
        'views_root' => FRONTEND_MODULE_ROOT . '/views'
    ),
    'backend' => array(
        'module_root' => BACKEND_MODULE_ROOT . '/',
        'controllers_root' => BACKEND_MODULE_ROOT . '/controllers',
        'models_root' => BACKEND_MODULE_ROOT . '/models'
    ),
    'application' => array(
        'application_root' => APPLICATION_ROOT . '/',
        'configs_root' => APPLICATION_ROOT . '/configs',
        'models_root' => APPLICATION_ROOT . '/models',
        'plugins_root' => APPLICATION_ROOT . '/plugins',
        'libraries_root' => APPLICATION_ROOT . '/libraries',
        'views_root' => APPLICATION_ROOT . '/views',
        'controllers_root' => APPLICATION_ROOT . '/controllers',
        'base_uri' => '/'
    )
));
