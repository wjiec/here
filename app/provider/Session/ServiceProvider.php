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
namespace Here\Provider\Session;

use Here\Provider\AbstractServiceProvider;
use Phalcon\Config;
use Phalcon\Session\AdapterInterface;


/**
 * Class ServiceProvider
 * @package Here\Provider\Session
 */
final class ServiceProvider extends AbstractServiceProvider {

    /**
     * Name of the service
     *
     * @var string
     */
    protected $service_name = 'session';

    /**
     * @inheritDoc
     */
    final public function register() {
        $this->di->setShared($this->service_name, function() {
            $config = container('config')->session;
            /* @var Config $driver_config */
            $driver_config = $config->drivers->{$config->default};
            $driver = $driver_config->adapter;

            /* @var AdapterInterface $session */
            $session = new $driver(array_merge($driver_config->toArray(), array(
                'prefix' => $config->prefix,
                'uniqueId' => $config->uniqueId,
                'lifetime' => $config->lifetime
            )));
            $session->start();

            return $session;
        });
    }

}
