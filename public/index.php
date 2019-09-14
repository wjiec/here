<?php
/**
 * The entry point of the application
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.org>
 * @copyright Copyright (C) 2016-2019 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/nosjay/here
 */
declare(strict_types=1);


namespace HereEntry;
use Phalcon\Di\FactoryDefault;


/* report all PHP errors */
error_reporting(E_ALL);
/* set default timezone to PRC(China) */
date_default_timezone_set('PRC');

/* some absolute path constants to aid in locating resources */
define('DOCUMENT_ROOT', __DIR__);
define('APPLICATION_ROOT', __DIR__ . '/here');

try {

    /**
     * dependency management
     * registers the services that provide a full stack framework.
     */
    $di = new FactoryDefault();

} catch (\Throwable $e) {
    // pass
}
