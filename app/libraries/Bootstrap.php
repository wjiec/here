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
use Here\Providers\ErrorHandler\ServiceProvider as ErrorHandlerServiceProvider;
use Here\Providers\EventsManager\ServiceProvider as EventsManagerServiceProvider;
use Here\Providers\ServiceProviderInstaller;
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
     * Application instance
     *
     * @var Application
     */
    private $app;

    /**
     * Dependency injection manager
     *
     * @var DiInterface
     */
    private $di;

    /**
     * Application environment
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
        $this->setupServiceProvider(new ErrorHandlerServiceProvider($this->di));

        /** @noinspection PhpIncludeInspection */
        $providers = include config_path('providers.php');
        if (is_array($providers)) {
            $this->setupServiceProviders($providers);
        }

        $this->app->setEventsManager(container('eventsManager'));

        /** @noinspection PhpIncludeInspection */
        $services = include config_path('services.php');
        if (is_array($services)) {
            $this->setupServices($services);
        }

        /** @noinspection PhpIncludeInspection */
        $modules = include config_path('modules.php');
        if (is_array($modules)) {
            $this->setupModules($modules);
        }
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
        $this->environment = env('BLOG_ENV', 'development');
        return $this->setupServiceProvider(new EnvironmentServiceProvider($this->di));
    }

    /**
     * Initializing the service provider
     *
     * @param ServiceProviderInterface $provider
     * @return Bootstrap
     */
    final private function setupServiceProvider(ServiceProviderInterface $provider) {
        ServiceProviderInstaller::setup($provider);
        return $this;
    }

    /**
     * Initializing the service providers.
     *
     * @param array $providers
     * @return $this
     */
    final private function setupServiceProviders(array $providers) {
        foreach ($providers as $provider) {
            $this->setupServiceProvider(new $provider($this->di));
        }
        return $this;
    }

    /**
     * Initializing the services
     *
     * @param array $services
     * @return Bootstrap
     */
    final private function setupServices(array $services) {
        foreach ($services as $name => $service) {
            $this->di->setShared($name, $services);
        }
        return $this;
    }

    /**
     * Initializing the modules
     *
     * @param array $modules
     * @return Bootstrap
     */
    final private function setupModules(array $modules) {
        $this->app->registerModules($modules);
        return $this;
    }

}
