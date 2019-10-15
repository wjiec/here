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
namespace Here\Providers\ModuleMeta;

use Here\Providers\AbstractServiceProvider;


/**
 * Class ServiceProvider
 * @package Here\Providers\ModuleMeta
 */
final class ServiceProvider extends AbstractServiceProvider {

    /**
     * Name of the service
     *
     * @var string
     */
    protected $service_name = 'moduleMeta';

    /**
     * @inheritDoc
     */
    final public function register() {
        $this->di->set($this->service_name, function(string $module) {
            $config = container('config')->modules;

            if (!isset($config->{$module}->meta)) {
                return array();
            }
            return $config->{$module}->meta;
        });
    }

}
