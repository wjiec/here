<?php
/**
 * This file is part of here
 *
 * @copyright Copyright (C) 2020 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/wjiec/here
 */
namespace Here\Provider\VoltExtension;

use Bops\Provider\AbstractServiceProvider;
use Here\Library\Mvc\View\Volt\Extension;


/**
 * Class ServiceProvider
 *
 * @package Here\Provider\VoltExtension
 */
class ServiceProvider extends AbstractServiceProvider {

    /**
     * Name of the service
     *
     * @return string
     */
    public function name(): string {
        return 'volt.extension';
    }

    /**
     * Register the service
     *
     * @return void
     */
    public function register() {
        $this->di->setShared($this->name(), function() {
            return new Extension();
        });
    }

}
