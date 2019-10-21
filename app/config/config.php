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
return array(
    'blog' => array(
        'name'          => env('HERE_NAME'),
        'url'           => env('HERE_URL'),
        'keywords'      => env('HERE_KEYWORDS'),
        'description'   => env('HERE_DESCRIPTION'),
        'robots'        => env('HERE_ALLOW_SPIDER')
    ),

    'application' => array(
        'debug'         => env('HERE_DEBUG'),
        'baseUri'       => env('HERE_BASE_URI'),
        'staticUri'     => env('HERE_STATIC_URL')
    ),

    'error' => array(
        'controller'    => 'error',
        'action'        => 'serverInternalError'
    )
);
