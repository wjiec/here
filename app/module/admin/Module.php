<?php
/**
 * This file is part of here
 *
 * @copyright Copyright (C) 2020 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/wjiec/here
 */
namespace Here\Admin;

use Bops\Module\AbstractModule;
use Phalcon\DiInterface;
use Phalcon\Loader;


/**
 * Class Module
 *
 * @package Here\Admin
 */
class Module extends AbstractModule {

    /**
     * Returns the name of the current module
     *
     * @return string
     */
    protected function moduleName(): string {
        return 'admin';
    }

    /**
     * Returns the path of module configure dir
     *
     * @return string
     */
    protected function configDir(): string {
        return __DIR__ . '/config';
    }

    /**
     * Registers an autoloader related to the module
     *
     * @param DiInterface $di
     */
    public function registerAutoloaders(DiInterface $di = null) {
        (new Loader())->registerNamespaces([
            'Here\Admin' => __DIR__,
            'Here\Admin\Controller' => __DIR__ . '/controller',
            'Here\Admin\Library' => __DIR__ . '/library'
        ])->register();
    }

}
