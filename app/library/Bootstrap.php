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
namespace Here\Library;

use Here\Provider\Application\Application;
use Here\Provider\Environment\ServiceProvider as EnvironmentServiceProvider;
use Here\Provider\ErrorHandler\ServiceProvider as ErrorHandlerServiceProvider;
use Here\Provider\EventsManager\ServiceProvider as EventsManagerServiceProvider;
use Here\Provider\ServiceProviderInstaller;
use Here\Provider\ServiceProviderInterface;
use Phalcon\Di;
use Phalcon\Di\FactoryDefault;
use Phalcon\DiInterface;


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
        $this->di->setShared('bootstrap', $this);

        $this->setupEnvironment();
        $this->setupServiceProvider(new EventsManagerServiceProvider($this->di));
        $this->setupServiceProvider(new ErrorHandlerServiceProvider($this->di));

        /** @noinspection PhpIncludeInspection */
        $providers = include config_path('providers.php');
        if (is_array($providers)) {
            $this->setupServiceProviders($providers);
        }
        $this->app = container('app');

        /** @noinspection PhpIncludeInspection */
        $services = include config_path('services.php');
        if (is_array($services)) {
            $this->setupServices($services);
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
        $this->environment = env('HERE_ENV', 'development');
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

}
