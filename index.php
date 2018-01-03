<?php
/**
 * Simple Blogger <Here>
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @version   Develop: 0.0.1
 * @link      https://github.com/JShadowMan/here
 */

/* enable strict mode */
declare(strict_types=1);

/* namespaces definitions */
namespace Here;
use Here\Config\Router\UserCollector;
use Here\Lib\Loader\Autoloader;
use Here\Lib\Router\Dispatcher;
use Here\Lib\Stream\IStream\Client\Request;
use Here\Lib\Stream\OStream\Client\Response;

/* the only explicit `require_once` to include `Autoloader` */
require_once 'Lib/Loader/Autoloader.php';

/* register classes loader and set default namespace */
Autoloader::add_namespace(__NAMESPACE__, __DIR__);

/* response environment initialization */
Response::init();

echo "<pre>";

/* create dispatcher for global */
$dispatcher = new Dispatcher(new UserCollector());

/* dispatch request resources */
$dispatcher->dispatch(Request::request_method(), Request::request_uri());

/* test case */
echo "</pre>";
