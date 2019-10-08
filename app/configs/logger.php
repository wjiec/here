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
    'root'      => cache_path('logs'),
    'format'    => env('LOGGER_FORMAT', "[%date%]\t - [%type%] : [%message%]"),
    'date'      => env('LOGGER_DATE', 'Y-m-d H:i:s'),
    'level'     => env('LOGGER_LEVEL', 'INFO'),
    'filename'  => env('LOGGER_FILENAME', 'blog'),
    'rotate'    => env('LOGGER_ROTATE', true)
);
