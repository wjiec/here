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
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Application;

/* report all PHP errors */
error_reporting(E_ALL);

/* application constant definition */
define('DOCUMENT_ROOT', dirname(__DIR__));
define('APPLICATION_ROOT', DOCUMENT_ROOT . '/app');


try {
    /**
     * dependency management
     * registers the services that provide a full stack framework.
     */
    $di = new FactoryDefault();

    /* handle routes */
    include APPLICATION_ROOT . '/config/router.php';

    /* read services */
    include APPLICATION_ROOT . '/config/services.php';

    /* get config service for use in inline setup below */
    // $config = $di->getConfig();

    /* autoloader component */
    include APPLICATION_ROOT . '/config/loader.php';

    /* handle the request */
    $application = new Application($di);

    /* return contents to client */
    echo str_replace(["\n","\r","\t"], '', $application->handle()->getContent());
} catch (\Exception $e) {
    echo $e->getMessage() . '<br>';
    echo '<pre>' . $e->getTraceAsString() . '</pre>';
}
