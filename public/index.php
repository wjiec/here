<?php
/**
 * entry for backend of here blogger
 *
 * @package   here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
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
define('APPLICATION_ROOT', DOCUMENT_ROOT . '/backend');

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

    /* doesn't not using view services */
    $application->useImplicitView(false);

    /* handle request */
    $response = $application->handle();

    /* send response to client */
    $response->send();
} catch (\Exception $e) {
    echo $e->getMessage() . '<br>';
    echo '<pre>' . $e->getTraceAsString() . '</pre>';
}
