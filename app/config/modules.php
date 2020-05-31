<?php
/**
 * This file is part of here
 *
 * @copyright Copyright (C) 2020 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/wjiec/here
 */
return [
    'admin' => [
        'path' => container('navigator')->moduleDir('admin/Module.php'),
        'className' => \Here\Admin\Module::class,
    ],
    'tinder' => [
        'path' => container('navigator')->moduleDir('tinder/Module.php'),
        'className' => \Here\Tinder\Module::class,
    ]
];
