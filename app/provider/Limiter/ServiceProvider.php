<?php
/**
 * This file is part of here
 *
 * @copyright Copyright (C) 2020 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/wjiec/here
 */
namespace Here\Provider\Limiter;

use Bops\Provider\AbstractServiceProvider;


/**
 * Class ServiceProvider
 *
 * @package Here\Provider\Limiter
 */
class ServiceProvider extends AbstractServiceProvider {

    /**
     * Name of the service
     *
     * @return string
     */
    public function name(): string {
        return 'limiter';
    }

    /**
     * @inheritDoc
     */
    public function register() {
        $this->di->set($this->name(), function(string $name) {
            return new Limiter($name);
        });
    }

}
