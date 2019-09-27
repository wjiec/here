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
namespace Here\Admin;

use Phalcon\DiInterface;
use Phalcon\Loader;
use Phalcon\Mvc\ModuleDefinitionInterface;


/**
 * Class Module
 * @package Here\Modules\Admin
 */
final class Module implements ModuleDefinitionInterface {

    /**
     * Registers an autoloader related to the module
     *
     * @param DiInterface $dependencyInjector
     * @return Loader
     */
    final public function registerAutoloaders(DiInterface $dependencyInjector = null) {
        return (new Loader())->registerNamespaces(array(
            'Here\Admin\Controllers\\' => __DIR__ . '/controllers',
            'Here\Admin\Providers\\' => __DIR__ . '/providers',
        ));
    }

    /**
     * Registers services related to the module
     *
     * @param DiInterface $dependencyInjector
     */
    final public function registerServices(DiInterface $dependencyInjector) {
    }

}
