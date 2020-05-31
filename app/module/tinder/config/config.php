<?php
/**
 * This file is part of here
 *
 * @copyright Copyright (C) 2020 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/wjiec/here
 */
return [
    'module' => [
        'dispatcher' => [
            'controllerNamespace' => 'Here\Tinder\Controller'
        ],
        'view' => [
            'uses' => true,
            'viewDir' => container('navigator')->moduleDir('tinder/view'),
        ],
    ],
];
