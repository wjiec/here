<?php
/**
 * This file is part of here
 *
 * @copyright Copyright (C) 2020 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/wjiec/here
 */
use Here\Admin\Module as AdminModule;
use Here\Tinder\Module as TinderModule;


return [
    'admin' => [
        'path' => container('navigator')->moduleDir('admin/Module.php'),
        'className' => AdminModule::class,
        'metadata' => [],
    ],
    'tinder' => [
        'path' => container('navigator')->moduleDir('tinder/Module.php'),
        'className' => TinderModule::class,
        'metadata' => [],
    ]
];
