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

use Phalcon\Cache\Backend\Libmemcached;
use Phalcon\Cache\Backend\Redis;

return array(
    'default' => env('CACHE_DRIVER', 'redis'),

    'drivers' => array(
        'redis' => array(
            'adapter'   => Redis::class,
            'host'      => env('REDIS_HOST', 'localhost'),
            'port'      => env('REDIS_PORT', 6379),
            'index'     => env('REDIS_INDEX', 0),
        ),
        'memcached' => array(
            'adapter'       => Libmemcached::class,
            'servers'       => array(
                'host'      => env('MEMCACHED_HOST', 'localhost'),
                'port'      => env('MEMCACHED_PORT', 11211),
                'weight'    => env('MEMCACHED_WEIGHT', 100)
            )
        )
    ),

    'prefix' => env('CACHE_PREFIX', 'here_cache_'),
    'lifetime' => env('CACHE_LIFETIME', 86400)
);
