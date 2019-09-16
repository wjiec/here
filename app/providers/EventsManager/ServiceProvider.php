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
namespace Here\Providers\EventsManager;

use Here\Providers\AbstractServiceProvider;
use Phalcon\Events\Manager as EventsManager;


/**
 * Class ServiceProvider
 * @package Here\Providers\EventsManager
 */
final class ServiceProvider extends AbstractServiceProvider {

    /**
     * Name of the service
     *
     * @var string
     */
    protected $service_name = 'eventsManager';

    /**
     * @inheritDoc
     */
    final public function register() {
        $this->di->setShared($this->service_name, function() {
            $manager = new EventsManager();
            $manager->enablePriorities(true);

            return $manager;
        });
    }

}
