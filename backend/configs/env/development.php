<?php
/**
 * development environment
 *
 * @package   Here
 * @author    Jayson Wang <jayson@laboys.org>
 * @copyright Copyright (C) 2016-2018 Jayson Wang
 */
namespace Here\Config\Env;


use Phalcon\Config;


/**
 * development
 */
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
            'lifetime' => 3600
        )
    ),
));
