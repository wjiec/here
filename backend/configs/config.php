<?php
/**
 * configure for Here
 *
 * @package   Here
 * @author    Jayson Wang <jayson@laboys.org>
 * @copyright Copyright (C) 2016-2018 Jayson Wang
 */
namespace Here\Config;


use Phalcon\Config;


return new Config(array(
    'application' => array(
        'configs_root' => APPLICATION_ROOT . '/configs',
        'models_root' => APPLICATION_ROOT . '/models',
        'plugins_root' => APPLICATION_ROOT . '/plugins',
        'libraries_root' => APPLICATION_ROOT . '/libraries',
        'controllers_root' => APPLICATION_ROOT . '/controllers',
        'controllers_namespace' => 'Here\Controllers',
        'languages_root' => APPLICATION_ROOT . '/configs/languages'
    ),
    'logging' => array(
        'default_logger' => 'application',
        'logging_root' => DOCUMENT_ROOT . '/logs',
        'spare_logging_root' => '/tmp/here/logs',
        'loggers' => array(
            'application' => array(
                'adapter' => 'File',
                'name' => 'application.log'
            ),
            'error' => array(
                'adapter' => 'File',
                'name' => 'error.log'
            )
        )
    ),
));
