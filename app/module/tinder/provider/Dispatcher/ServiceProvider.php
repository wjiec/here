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
namespace Here\Tinder\Provider\Dispatcher;

use Here\Library\Listener\Adapter\Dispatcher as DispatcherListener;
use Here\Provider\AbstractServiceProvider;
use Phalcon\Mvc\Dispatcher as MvcDispatcher;


/**
 * Class ServiceProvider
 * @package Here\Tinder\Provider\Dispatcher
 */
final class ServiceProvider extends AbstractServiceProvider {

    /**
     * Name of the service
     *
     * @var string
     */
    protected $service_name = 'dispatcher';

    /**
     * @inheritdoc
     */
    final public function register() {
        $this->di->setShared($this->service_name, function() {
            $dispatcher = new MvcDispatcher();

            $dispatcher->setDefaultNamespace('Here\Tinder\Controller');
            $dispatcher->setEventsManager(container('eventsManager'));
            container('eventsManager')->attach('dispatch', new DispatcherListener());

            return $dispatcher;
        });
    }

}
