<?php
/**
 * This file is part of here
 *
 * @copyright Copyright (C) 2020 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/wjiec/here
 */
namespace Here\Provider\Cookies;

use Bops\Provider\AbstractServiceProvider;


/**
 * Class ServiceProvider
 *
 * @package Here\Provider\Cookies
 */
class ServiceProvider extends AbstractServiceProvider {

    /**
     * Name of the service
     *
     * @return string
     */
    public function name(): string {
        return 'cookies';
    }

    /**
     * @inheritDoc
     */
    public function register() {
        $this->di->setShared($this->name(), function() {
            return new Cookies(false, null);
        });
    }

}
