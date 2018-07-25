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
     * @param DiInterface|null $di
     */
    final public function registerAutoloaders(DiInterface $di = null) {
    }

    /**
     * @param DiInterface $di
     */
    final public function registerServices(DiInterface $di) {
        /* register default dispatcher */
//        $di->set('dispatcher', function() {
//            $dispatcher = new Dispatcher();
//            $dispatcher->setDefaultNamespace('Here\Frontend\Controllers');
//
//            return $dispatcher;
//        });
    }
}
