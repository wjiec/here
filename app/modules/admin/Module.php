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
namespace Here\Modules\Admin;

use Phalcon\DiInterface;
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
     */
    final public function registerAutoloaders(DiInterface $dependencyInjector = null) {
    }

    /**
     * Registers services related to the module
     *
     * @param DiInterface $dependencyInjector
     */
    final public function registerServices(DiInterface $dependencyInjector) {
    }

}
