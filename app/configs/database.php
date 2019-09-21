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

use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Db\Adapter\Pdo\Postgresql;


return array(
    'default' => env('DB_DRIVER', 'postgresql'),

    'drivers' => array(
        'mysql' => array(
            'adapter'       => Mysql::class,
            'host'          => env('DB_HOST', 'localhost'),
            'port'          => env('DB_PORT', 3306),
            'username'      => env('DB_USERNAME', 'root'),
            'password'      => env('DB_PASSWORD', 'root'),
            'dbname'        => env('DB_DATABASE', 'here'),
            'charset'       => env('DB_CHARSET', 'utf8'),
            'options'       => array(
                PDO::FETCH_ASSOC            => true,
                PDO::ATTR_EMULATE_PREPARES  => false,
                PDO::ATTR_STRINGIFY_FETCHES => false,
            )
        ),
        'postgresql' => array(
            'adapter'       => Postgresql::class,
            'host'          => env('DB_HOST', 'localhost'),
            'port'          => env('DB_PORT', 5432),
            'username'      => env('DB_USERNAME', 'root'),
            'password'      => env('DB_PASSWORD', 'root'),
            'dbname'        => env('DB_DATABASE', 'here'),
            'schema'        => env('DB_SCHEMA', 'public'),
        )
    )
);
