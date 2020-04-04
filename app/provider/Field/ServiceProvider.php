<?php
/**
 * This file is part of here
 *
 * @copyright Copyright (C) 2020 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/wjiec/here
 */
namespace Here\Provider\Field;

use Bops\Provider\AbstractServiceProvider;
use Here\Provider\Field\Store\Adapter\Cache;
use Here\Provider\Field\Store\Adapter\Database;
use Here\Provider\Field\Store\Adapter\Memory;
use Here\Provider\Field\Store\Adapter\Mixed;


/**
 * Class ServiceProvider
 * @package Here\Provider\Field
 */
class ServiceProvider extends AbstractServiceProvider {

    /**
     * Name of the service
     *
     * @return string
     */
    public function name(): string {
        return 'field';
    }

    /**
     * @inheritdoc
     */
    public function register() {
        $this->di->set($this->name(), function() {
            return new Mixed(new Memory(), new Cache(), new Database());
        });
    }

}
