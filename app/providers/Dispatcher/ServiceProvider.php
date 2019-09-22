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
namespace Here\Providers\Dispatcher;

use Here\Providers\AbstractServiceProvider;
use Phalcon\Mvc\Dispatcher;


/**
 * Class ServiceProvider
 * @package Here\Providers\Dispatcher
 */
class ServiceProvider extends AbstractServiceProvider {

    /**
     * Name of service
     *
     * @var string
     */
    protected $service_name = 'dispatcher';

    /**
     * Default controller namespace
     *
     * @var string
     */
    protected $default_namespace;

    /**
     * @inheritDoc
     */
    public function register() {
        $namespace = $this->default_namespace;
        $this->di->setShared($this->service_name, function() use ($namespace) {
            $dispatcher = new Dispatcher();
            $dispatcher->setDefaultNamespace($namespace);

            return $dispatcher;
        });
    }

}
