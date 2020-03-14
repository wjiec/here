<?php
/**
 * here application
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.org>
 * @copyright Copyright (C) 2016-2019 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/wjiec/here
 */
namespace Here\Admin;

use Here\Admin\Provider\Dispatcher\ServiceProvider as DispatcherServiceProvider;
use Here\Admin\Provider\View\ServiceProvider as ViewServiceProvider;
use Here\Provider\ServiceProviderInstaller;
use Phalcon\DiInterface;
use Phalcon\Loader;
use Phalcon\Mvc\ModuleDefinitionInterface;


/**
 * Class Module
 * @package Here\Admin
 */
final class Module implements ModuleDefinitionInterface {

    /**
     * Registers an autoloader related to the module
     *
     * @param DiInterface $di
     */
    final public function registerAutoloaders(DiInterface $di = null) {
        (new Loader())->registerNamespaces([
            'Here\Admin' => __DIR__,
            'Here\Admin\Controller' => __DIR__ . DIRECTORY_SEPARATOR . 'controller',
            'Here\Admin\Library' => __DIR__ . DIRECTORY_SEPARATOR . 'library',
            'Here\Admin\Provider' => __DIR__ . DIRECTORY_SEPARATOR . 'provider'
        ])->register();
    }

    /**
     * Registers services related to the module
     *
     * @param DiInterface $di
     */
    final public function registerServices(DiInterface $di) {
        ServiceProviderInstaller::setup(new DispatcherServiceProvider($di));
        ServiceProviderInstaller::setup(new ViewServiceProvider($di));
    }

}
