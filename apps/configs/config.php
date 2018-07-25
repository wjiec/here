<?php
/**
 * configure for Here
 *
 * @package   Here
 * @author    Jayson Wang <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 Jayson Wang
 */
namespace Here\Config;
use Here\Backend\BackendModule;
use Here\Frontend\FrontendModule;
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
        'base_uri' => '/',
        'caches_root' => DOCUMENT_ROOT . '/caches',
        'logging_root' => DOCUMENT_ROOT . '/logs'
    ),
    'modules' => array(
        'frontend' => array(
            'className' => FrontendModule::class,
            'path' => FRONTEND_MODULE_ROOT . '/FrontendModule.php',
            'metadata' => array(
                'controllers_namespace' => 'Here\Frontend\Controllers',
                'controllers_suffix' => '',
                'actions_suffix' => ''
            )
        ),
        'backend' => array(
            'className' => BackendModule::class,
            'path' => BACKEND_MODULE_ROOT . '/BackendModule.php',
            'metadata' => array(
                'controllers_namespace' => 'Here\Backend\Controllers',
                'controllers_suffix' => '',
                'actions_suffix' => ''
            )
        )
    ),
    'logging' => array(
        'adapter' => 'File',
        'name' => 'here.log'
    )
));
