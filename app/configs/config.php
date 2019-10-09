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
        'name'          => env('BLOG_NAME'),
        'url'           => env('BLOG_URL'),
        'keywords'      => env('BLOG_KEYWORDS'),
        'description'   => env('BLOG_DESCRIPTION')
    ),

    'application' => array(
        'debug'         => env('BLOG_DEBUG'),
        'baseUri'       => env('BLOG_BASE_URI'),
        'staticUri'     => env('BLOG_STATIC_URL')
    ),

    'error' => array(
        'controller'    => 'error',
        'action'        => 'serverInternalError'
    )
);
