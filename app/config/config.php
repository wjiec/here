<?php
/**
 * This file is part of here
 *
 * @copyright Copyright (C) 2020 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/wjiec/here
 */
return [
    'security' => [
        'cap' => "script-src 'self'; object-src 'none'; style-src 'self'; child-src 'none';",
        'frameOptions' => 'deny',
        'xssProtection' => '1; mode=block'
    ]
];
