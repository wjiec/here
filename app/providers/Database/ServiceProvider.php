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
namespace Here\Providers\Database;

use Here\Libraries\Listener\Database;
use Here\Providers\AbstractServiceProvider;
use Phalcon\Db\Adapter;


/**
 * Class ServiceProvider
 * @package Here\Providers\Database
 */
final class ServiceProvider extends AbstractServiceProvider {

    /**
     * Name of service
     *
     * @var string
     */
    protected $service_name = 'db';

    /**
     * @inheritDoc
     */
    final public function register() {
        $this->di->setShared($this->service_name, function() {
            $config = container('config')->database;
            $driver_config = $config->drivers->{$config->default};
            $driver = $driver_config->adapter;

            /* @var Adapter $connection */
            $connection = new $driver($driver_config);
            $connection->setEventsManager(container('eventsManager'));
            container('eventsManager')->attach('db', new Database());

            return $connection;
        });
    }

}
