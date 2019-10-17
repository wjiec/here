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
namespace Here\Api;

use Phalcon\DiInterface;
use Phalcon\Loader;
use Phalcon\Mvc\ModuleDefinitionInterface;


/**
 * Class Module
 * @package Here\Api
 */
final class Module implements ModuleDefinitionInterface {

    /**
     * Registers an autoloader related to the module
     *
     * @param DiInterface $di
     */
    final public function registerAutoloaders(DiInterface $di = null) {
        (new Loader())->registerNamespaces(array(
            'Here\Api' => __DIR__,
            'Here\Api\Controllers' => __DIR__ . '/controllers',
            'Here\Api\Providers' => __DIR__ . '/providers'
        ))->register();
    }

    /**
     * Registers services related to the module
     *
     * @param DiInterface $di
     */
    final public function registerServices(DiInterface $di) {
    }

}
