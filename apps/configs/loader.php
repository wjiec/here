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

/* autoload collector */
$loader = new Loader();

/* register namespace to loader */
$loader->registerNamespaces(array(
    'Here\Libraries' => $di->get('config')->application->libraries_root,
    'Here\Plugins' => $di->get('config')->application->plugins_root,
    'Here\Models' => $di->get('config')->application->models_root,
    'Here\Controllers' => $di->get('config')->application->controllers_root
));

/* create an autoloader */
$loader->register();
