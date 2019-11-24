<?php
/**
 * here application
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.org>
 * @copyright Copyright (C) 2016-2019 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/lsalio/here
 */
namespace Here\Tinder;

use Here\Provider\ServiceProviderInstaller;
use Here\Tinder\Provider\Dispatcher\ServiceProvider as DispatcherServiceProvider;
use Here\Tinder\Provider\View\ServiceProvider as ViewServiceProvider;
use Phalcon\DiInterface;
use Phalcon\Loader;
use Phalcon\Mvc\ModuleDefinitionInterface;


/**
 * Class Module
 * @package Here\Tinder
 */
final class Module implements ModuleDefinitionInterface {

    /**
     * Registers an autoloader related to the module
     *
     * @param DiInterface|null $di
     */
    final public function registerAutoloaders(DiInterface $di = null) {
        (new Loader())->registerNamespaces([
            'Here\Tinder' => __DIR__,
            'Here\Tinder\Controller' => __DIR__ . DIRECTORY_SEPARATOR . 'controller',
            'Here\Tinder\Library' => __DIR__ . DIRECTORY_SEPARATOR . 'library',
            'Here\Tinder\Provider' => __DIR__ . DIRECTORY_SEPARATOR . 'provider'
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
