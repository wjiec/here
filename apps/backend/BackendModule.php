<?php
/**
 * BackendModule.php
 *
 * @package   here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Backend;


use Phalcon\DiInterface;
use Phalcon\Loader;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\ModuleDefinitionInterface;


/**
 * Class BackendModule
 * @package Here\Backend
 */
final class BackendModule implements ModuleDefinitionInterface {
    /**
     * @param DiInterface|null $di
     */
    final public function registerAutoloaders(DiInterface $di = null) {
    }

    /**
     * @param DiInterface $di
     */
    final public function registerServices(DiInterface $di) {
        /* register default dispatcher */
//        $dependencyInjector->set('dispatcher', function() {
//            $dispatcher = new Dispatcher();
//            $dispatcher->setDefaultNamespace('Here\Backend\Controllers');
//
//            return $dispatcher;
//        });
    }
}
