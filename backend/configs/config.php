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
        'adapter' => 'Mysql',
        'host' => 'mysql',
        'username' => 'root',
        'password' => 'root',
        'dbname' => 'here',
        'charset' => 'utf8mb4',
    ),
    'cache' => array(
        'backend' => array(
            'adapter' => 'Redis',
            'host' => 'redis',
            'port' => '6379'
        ),
        'frontend' => array(
            'adapter' => 'Data',
            'lifetime' => 5 * 60
        )
    ),
    'logging' => array(
        'adapter' => 'File',
        'name' => 'here.log'
    ),
    'application' => array(
        'application_root' => APPLICATION_ROOT . '/',
        'configs_root' => APPLICATION_ROOT . '/configs',
        'models_root' => APPLICATION_ROOT . '/models',
        'plugins_root' => APPLICATION_ROOT . '/plugins',
        'libraries_root' => APPLICATION_ROOT . '/libraries',
        'controllers_root' => APPLICATION_ROOT . '/controllers',
        'controllers_namespace' => 'Here\Controllers',
        'base_uri' => '/',
        'logging_root' => DOCUMENT_ROOT . '/logs'
    )
));
