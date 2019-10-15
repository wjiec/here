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
namespace Here\Stage;

use Here\Providers\ServiceProviderInstaller;
use Here\Stage\Providers\Dispatcher\ServiceProvider as DispatcherServiceProvider;
use Here\Stage\Providers\View\ServiceProvider as ViewServiceProviderAlias;
use Phalcon\DiInterface;
use Phalcon\Loader;
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
        (new Loader())->registerNamespaces(array(
            'Here\Stage' => __DIR__,
            'Here\Stage\Controllers' => __DIR__ . '/controllers',
            'Here\Stage\Providers' => __DIR__ . '/providers',
        ))->register();
    }

    /**
     * Registers services related to the module
     *
     * @param DiInterface $di
     */
    final public function registerServices(DiInterface $di) {
        ServiceProviderInstaller::setup(new DispatcherServiceProvider($di));
        ServiceProviderInstaller::setup(new ViewServiceProviderAlias($di));
    }

}
