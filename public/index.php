<?php
/**
 * Simple Blogger <Here>
 *
 * @package   Here
 * @author    Jayson Wang <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 Jayson Wang
 * @license   MIT License
 * @version   Develop: 0.0.1
 * @link      https://github.com/JJayson Wang/here
 */
declare(strict_types=1);

/* namespace definition and use declaration */
namespace Here;


use Here\Backend\BackendModule;
use Here\Frontend\FrontendModule;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Application;


/* report all PHP errors */
error_reporting(E_ALL);

/* application constant definition */
define('DOCUMENT_ROOT', dirname(__DIR__));
define('APPLICATION_ROOT', DOCUMENT_ROOT . '/apps');
define('FRONTEND_MODULE_ROOT', APPLICATION_ROOT . '/frontend');
define('BACKEND_MODULE_ROOT', APPLICATION_ROOT . '/backend');


try {
    /**
     * dependency management
     * registers the services that provide a full stack framework.
     */
    $di = new FactoryDefault();

    /* handle routes */
    include APPLICATION_ROOT . '/configs/router.php';

    /* read services */
    include APPLICATION_ROOT . '/configs/services.php';

    /* autoloader component */
    include APPLICATION_ROOT . '/configs/loader.php';

    /* handle the request */
    $application = new Application($di);

    /* register modules */
    $application->registerModules($di->get('config')->modules->toArray());

    /* handle request */
    $response = $application->handle();

    /* send response to client */
    $response->send();
} catch (\Exception $e) {
    echo $e->getMessage() . '<br>';
    echo '<pre>' . $e->getTraceAsString() . '</pre>';
}
