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
namespace Here\Provider\ViewCache;

use Here\Provider\AbstractServiceProvider;
use Phalcon\Cache\Frontend\Output;
use Phalcon\Config;


/**
 * Class ServiceProvider
 * @package Here\Provider\ViewCache
 */
class ServiceProvider extends AbstractServiceProvider {

    /**
     * Name of service
     *
     * @var string
     */
    protected $service_name = 'viewCache';

    /**
     * @inheritDoc
     */
    public function register() {
        // The frontend must always be Phalcon\Cache\Frontend\Output and
        // the service viewCache must be registered as always open (not shared)
        // in the services container (DI).
        $this->di->set($this->service_name, function() {
            $config = container('config')->cache;
            /* @var Config $driver_config */
            $driver_config = $config->drivers->{$config->default};

            /** @noinspection PhpUndefinedFieldInspection */
            $driver = $driver_config->adapter;
            $driver_config = array_merge($driver_config->toArray(), ['prefix' => $config->prefix . ':view:']);

            return new $driver(new Output(['lifetime' => $config->lifetime]), $driver_config);
        });
    }

}
