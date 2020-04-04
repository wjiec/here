<?php
/**
 * This file is part of here
 *
 * @copyright Copyright (C) 2020 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/wjiec/here
 */
namespace Here\Provider\Welcome;

use Bops\Provider\AbstractServiceProvider;


/**
 * Class ServiceProvider
 *
 * @package Here\Provider\Welcome
 */
class ServiceProvider extends AbstractServiceProvider {

    /**
     * Name of the service
     *
     * @return string
     */
    public function name(): string {
        return 'welcome';
    }

    /**
     * @inheritDoc
     */
    public function register() {
        $this->di->set($this->name(), function(string $timezone = '') {
            return new Welcome($timezone ?: container('config')->timezone->default);
        });
    }

}
