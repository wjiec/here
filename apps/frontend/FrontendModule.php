<?php
/**
 * FrontendModule.php
 *
 * @package   here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Frontend;


use Phalcon\DiInterface;
use Phalcon\Loader;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\ModuleDefinitionInterface;


/**
 * Class FrontendModule
 * @package Here\Frontend
 */
final class FrontendModule implements ModuleDefinitionInterface {
    /**
     * @param DiInterface|null $dependencyInjector
     */
    final public function registerAutoloaders(DiInterface $dependencyInjector = null) {
        $loader = new Loader();

        $loader->registerNamespaces(array(
            'Here\Frontend\Controllers' => $dependencyInjector->get('config')->frontend->controllers_root,
            'Here\Frontend\Models' => $dependencyInjector->get('config')->frontend->models_root
        ))->register();
    }

    /**
     * @param DiInterface $dependencyInjector
     */
    final public function registerServices(DiInterface $dependencyInjector) {
        /* register default dispatcher */
        $dependencyInjector->set('dispatcher', function() {
            $dispatcher = new Dispatcher();
            $dispatcher->setDefaultNamespace('Here\Frontend\Controllers');

            return $dispatcher;
        });
    }
}
