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
namespace Here\Provider\Config;

use Here\Provider\AbstractServiceProvider;


/**
 * Class ServiceProvider
 * @package Here\Provider\Config
 */
final class ServiceProvider extends AbstractServiceProvider {

    /**
     * Name of the service
     *
     * @var string
     */
    protected $service_name = 'config';

    /**
     * Components of configure
     *
     * @var array
     */
    protected $configs = array(
        'cache',
        'config',
        'database',
        'logger',
        'session',
        'timezone'
    );

    /**
     * @inheritDoc
     */
    final public function register() {
        $configs = $this->configs;
        $this->di->setShared($this->service_name, function() use ($configs) {
            return Factory::create($configs);
        });
    }

}
