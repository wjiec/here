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
use Phalcon\Session\Adapter\Redis;


return array(
    'default' => env('SESSION_DRIVER', 'redis'),

    'drivers' => array(
        'redis' => array(
            'adapter'       => Redis::class,
            'host'          => env('REDIS_HOST', 'localhost'),
            'port'          => env('REDIS_PORT', 6379),
            'index'         => env('REDIS_INDEX', 0),
            'persistent'    => true,
        )
    ),

    'prefix' => env('SESSION_PREFIX', 'here_session_'),
    'uniqueId' => env('SESSION_UNIQUE_ID', 'here_'),
    'lifetime' => env('SESSION_LIFETIME', 3600),
);
