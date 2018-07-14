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
        'charset'     => 'utf8',
    ),
    'redis' => array(
        'adapter'   => 'Redis',
        'host'      => 'redis',
    ),
    'application' => array(
        'application_root'  => APPLICATION_ROOT . '/',
        'controllers_root'  => APPLICATION_ROOT . '/controllers',
        'models_root'       => APPLICATION_ROOT . '/models',
        'migrations_root'   => APPLICATION_ROOT . '/migrations',
        'views_root'        => APPLICATION_ROOT . '/views',
        'plugins_root'      => APPLICATION_ROOT . '/plugins',
        'library_root'      => APPLICATION_ROOT . '/library',
        'base_uri'          => '/',
    )
));
