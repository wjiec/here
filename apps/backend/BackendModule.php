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
     * @param DiInterface|null $dependencyInjector
     */
    final public function registerAutoloaders(DiInterface $dependencyInjector = null) {
        $loader = new Loader();

        $loader->registerNamespaces(array(
            'Here\Backend\Controllers' => $dependencyInjector->get('config')->backend->controllers_root,
            'Here\Backend\Models' => $dependencyInjector->get('config')->backend->models_root
        ))->register();
    }

    /**
     * @param DiInterface $dependencyInjector
     */
    final public function registerServices(DiInterface $dependencyInjector) {
        /* register default dispatcher */
        $dependencyInjector->set('dispatcher', function() {
            $dispatcher = new Dispatcher();
            $dispatcher->setDefaultNamespace('Here\Backend\Controllers');

            return $dispatcher;
        });
    }
}
