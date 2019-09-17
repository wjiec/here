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
namespace Here\Modules\Stage;

use Phalcon\DiInterface;
use Phalcon\Mvc\ModuleDefinitionInterface;


/**
 * Class Module
 * @package Here\Modules\Stage
 */
final class Module implements ModuleDefinitionInterface {

    /**
     * Registers an autoloader related to the module
     *
     * @param DiInterface|null $di
     */
    final public function registerAutoloaders(DiInterface $di = null) {
    }

    /**
     * Registers services related to the module
     *
     * @param DiInterface $di
     */
    final public function registerServices(DiInterface $di) {
    }

}
