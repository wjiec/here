<?php
/**
 * here application
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.org>
 * @copyright Copyright (C) 2016-2019 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/wjiec/here
 */
return [
    'root'      => storage_path('log'),
    'format'    => env('LOGGER_FORMAT', "%date% - %type% \t: %message%"),
    'date'      => env('LOGGER_DATE', 'Y-m-d H:i:s'),
    'level'     => env('LOGGER_LEVEL', 'INFO'),
    'filename'  => env('LOGGER_FILENAME', 'here'),
    'rotate'    => env('LOGGER_ROTATE', true)
];
