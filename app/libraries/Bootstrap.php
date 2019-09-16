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
namespace Here\Libraries;

use Here\Providers\Environment\ServiceProvider as EnvironmentServiceProvider;
use Here\Providers\EventsManager\ServiceProvider as EventsManagerServiceProvider;
use Here\Providers\ServiceProviderInterface;
use Phalcon\Application;
use Phalcon\Di;
use Phalcon\Di\FactoryDefault;
use Phalcon\DiInterface;
use Phalcon\Mvc\Application as MvcApplication;


/**
 * Class Bootstrap
 * @package Here
 */
final class Bootstrap {

    /**
     * @var Application
     */
    private $app;

    /**
     * @var DiInterface
     */
    private $di;

    /**
     *
     *
     * @var string
     */
    private $environment;

    /**
     * Bootstrap constructor.
     */
    final public function __construct() {
        $this->di = new FactoryDefault();
        Di::setDefault($this->di);

        $this->app = new MvcApplication($this->di);
        $this->app->setDI($this->di);

        $this->di->setShared('app', $this->app);
        $this->di->setShared('bootstrap', $this);

        $this->setupEnvironment();
        $this->setupServiceProvider(new EventsManagerServiceProvider($this->di));
    }

    /**
     * Get the application environment
     *
     * @return string
     */
    final public function getEnvironment(): string {
        return $this->environment;
    }

    /**
     * Run the application
     *
     * @return $this
     */
    final public function run(): string {
        return $this->app->handle()->getContent();
    }

    /**
     * Setup the application environment
     */
    final private function setupEnvironment() {
        $this->environment = env('APP_ENV', 'development');
        return $this->setupServiceProvider(new EnvironmentServiceProvider($this->di));
    }

    /**
     * Initializing the service provider
     *
     * @param ServiceProviderInterface $provider
     * @return Bootstrap
     */
    final private function setupServiceProvider(ServiceProviderInterface $provider) {
        $provider->register();
        return $this;
    }

}
