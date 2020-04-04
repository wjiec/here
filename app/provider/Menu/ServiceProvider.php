<?php
/**
 * This file is part of here
 *
 * @copyright Copyright (C) 2020 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/wjiec/here
 */
namespace Here\Provider\Menu;

use Bops\Provider\AbstractServiceProvider;


/**
 * Class ServiceProvider
 *
 * @package Here\Provider\Menu
 */
class ServiceProvider extends AbstractServiceProvider {

    /**
     * Name of the service
     *
     * @return string
     */
    public function name(): string {
        return 'menu';
    }

    /**
     * @inheritDoc
     */
    public function register() {
        $this->di->setShared($this->name(), function() {
            return new Menu(container('config')->menu->toArray());
        });
    }

}
