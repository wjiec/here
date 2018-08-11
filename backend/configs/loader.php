<?php
/**
 * autoloader
 *
 * @package   Here
 * @author    Jayson Wang <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 Jayson Wang
 */
namespace Here\Config;


use Phalcon\Di;
use Phalcon\Loader;


/* dependency management */
$di = Di::getDefault();

/* configure service */
$config = $di->get('config');

/* autoload collector */
$loader = new Loader();

/* register namespace to loader */
$loader->registerNamespaces(array(
    /* libraries and plugins */
    'Here\Libraries' => $config->application->libraries_root,
    'Here\Plugins' => $config->application->plugins_root,
    /* controllers and models */
    'Here\Controllers' => $config->application->controllers_root,
    'Here\Models' => $config->application->models_root,
));

/* create an autoloader */
$loader->register();
