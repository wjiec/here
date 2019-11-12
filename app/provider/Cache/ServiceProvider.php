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
namespace Here\Provider\Cache;

use Here\Provider\AbstractServiceProvider;
use Phalcon\Cache\Frontend\Data;
use Phalcon\Config;


/**
 * Class ServiceProvider
 * @package Here\Provider\Cache
 */
final class ServiceProvider extends AbstractServiceProvider {

    /**
     * Name of the service
     *
     * @var string
     */
    protected $service_name = 'cache';

    /**
     * @inheritdoc
     */
    final public function register() {
        $this->di->setShared($this->service_name, function() {
            $config = container('config')->cache;
            /* @var Config $driver_config */
            $driver_config = $config->drivers->{$config->default};

            /** @noinspection PhpUndefinedFieldInspection */
            $driver = $driver_config->adapter;
            $driver_config = array_merge($driver_config->toArray(), array('prefix' => $config->prefix));

            return new $driver(new Data(array(
                'lifetime' => $config->lifetime
            )), $driver_config);
        });
    }

}
