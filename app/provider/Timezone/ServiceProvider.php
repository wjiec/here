<?php
/**
 * This file is part of here
 *
 * @copyright Copyright (C) 2020 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/wjiec/here
 */
namespace Here\Provider\Timezone;

use Bops\Provider\AbstractServiceProvider;


/**
 * Class ServiceProvider
 *
 * @package Here\Provider\Timezone
 */
final class ServiceProvider extends AbstractServiceProvider {

    /**
     * Name of the service
     *
     * @return string
     */
    public function name(): string {
        return 'timezone';
    }

    /**
     * @inheritDoc
     */
    final public function register() {
        $this->di->set($this->name(), function(?string $timezone = null) {
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
        container($this->name());
    }

}
