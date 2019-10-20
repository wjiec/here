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
namespace Here\Stage\Providers\Dispatcher;

use Here\Libraries\Listener\Adapter\Dispatcher as DispatcherListener;
use Here\Providers\AbstractServiceProvider;
use Phalcon\Mvc\Dispatcher as MvcDispatcher;


/**
 * Class ServiceProvider
 * @package Here\Stage\Providers\Dispatcher
 */
final class ServiceProvider extends AbstractServiceProvider {

    /**
     * Name of service
     *
     * @var string
     */
    protected $service_name = 'dispatcher';

    /**
     * @inheritDoc
     */
    final public function register() {
        $this->di->setShared($this->service_name, function() {
            $dispatcher = new MvcDispatcher();

            $dispatcher->setDefaultNamespace('Here\Stage\Controllers');
            $dispatcher->setEventsManager(container('eventsManager'));
            container('eventsManager')->attach('dispatch', new DispatcherListener());

            return $dispatcher;
        });
    }

}
