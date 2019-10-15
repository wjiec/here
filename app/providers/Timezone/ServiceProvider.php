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
namespace Here\Providers\Timezone;

use Here\Providers\AbstractServiceProvider;


/**
 * Class ServiceProvider
 * @package Here\Providers\Timezone
 */
final class ServiceProvider extends AbstractServiceProvider {

    /**
     * Name of the service
     *
     * @var string
     */
    protected $service_name = 'timezone';

    /**
     * @inheritDoc
     */
    final public function register() {
        $this->di->set($this->service_name, function(?string $timezone = null) {
            $config = container('config')->timezone;
            if (!$timezone) {
                $timezone = $config->default;
            }

            date_default_timezone_set($timezone);
            return $timezone;
        });
    }

    /**
     * @inheritDoc
     */
    final public function initialize() {
        container($this->service_name);
    }

}
