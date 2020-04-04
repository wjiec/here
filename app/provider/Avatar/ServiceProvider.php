<?php
/**
 * This file is part of here
 *
 * @copyright Copyright (C) 2020 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/wjiec/here
 */
namespace Here\Provider\Avatar;

use Bops\Provider\AbstractServiceProvider;


/**
 * Class ServiceProvider
 *
 * @package Here\Provider\Avatar
 */
class ServiceProvider extends AbstractServiceProvider {

    /**
     * Name of the service
     *
     * @return string
     */
    public function name(): string {
        return 'avatar';
    }

    /**
     * @inheritDoc
     */
    public function register() {
        $this->di->setShared($this->name(), function() {
            return new Avatar();
        });
    }

}
