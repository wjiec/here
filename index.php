<?php
/**
 * Simple Blogger <Here>
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @version   Develop: 0.1.0
 * @link      https://github.com/JShadowMan/here
 */

/* enable strict mode */
declare(strict_types=1);

/* namespaces definitions */
namespace Here;
use Here\Config\UserCollector;
use Here\Lib\Loader\Autoloader;
use Here\Lib\Io\Input\Request;
use Here\Lib\Router\Dispatcher;

/* root absolute path with `Here` */
define('__HERE_ROOT_DIRECTORY__', str_replace('\\', '/', dirname(__FILE__)));

/* the only explicit `require_once` to include `Autoloader` */
require_once 'lib/loader/Autoloader.php';

/* register root directory (must be call first) */
Autoloader::set_root('Here', __HERE_ROOT_DIRECTORY__);

/* register `Here\Lib` namespace */
Autoloader::register('Here\Lib', '/lib');

/* register `Here\Conf` namespace */
Autoloader::register('Here\Config', '/etc');

/* create router dispatcher instance */
$router_dispatcher = new Dispatcher(new UserCollector());

/* start dispatch */
$router_dispatcher->dispatch(Request::request_method(), Request::request_uri());
