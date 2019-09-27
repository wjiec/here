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
use Here\Stage\Module;


return array(
    'admin' => array(
        'className' => AdminModule::class,
        'path' => APP_MODULES_ROOT . '/admin',
        'meta' => array()
    ),
    'stage' => array(
        'className' => Module::class,
        'path' => APP_MODULES_ROOT . '/stage/Module.php',
        'meta' => array()
    )
);
