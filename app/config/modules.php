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
use Here\Admin\Module as AdminModule;


return array(
    'admin' => array(
        'class' => AdminModule::class,
        'path' => module_path('admin/Module.php')
    ),
);
