<?php
/**
 * entry for backend of here blogger
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.org>
 * @copyright Copyright (C) 2016-2018 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
declare(strict_types=1);


/* namespace definition and use declaration */
namespace Here;


use Here\Libraries\Hunter\ErrorCatcher;
use Here\Libraries\Stream\OutputBuffer;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Application;


/* report all errors */
error_reporting(E_ALL);

/* application constant definition */
define('DOCUMENT_ROOT', dirname(__DIR__));
define('APPLICATION_ROOT', DOCUMENT_ROOT . '/backend');

/* application environment */
include_once APPLICATION_ROOT . '/configs/constants.php';


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

    /* register output buffer */
    OutputBuffer::startup();

    /* prepare ErrorHunter */
    ErrorCatcher::prepare();

    /* handle the request */
    $application = new Application($di);

    /* doesn't not using view services */
    $application->useImplicitView(false);

    /* handle request */
    $response = $application->handle();

    /* send response to client */
    $response->send();
} catch (\Exception $e) {
    /** @noinspection PhpUnhandledExceptionInspection */
    throw $e; // throw again and catch by ErrorHunter
}
