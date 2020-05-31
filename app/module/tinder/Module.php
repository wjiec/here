<?php
/**
 * This file is part of here
 *
 * @copyright Copyright (C) 2020 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/wjiec/here
 */
namespace Here\Tinder;

use Bops\Module\AbstractModule;
use Phalcon\DiInterface;
use Phalcon\Loader;


/**
 * Class Module
 *
 * @package Here\Tinder
 */
class Module extends AbstractModule {

    /**
     * Returns the name of the current module
     *
     * @return string
     */
    protected function moduleName(): string {
        return 'tinder';
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
            'Here\Tinder' => __DIR__,
            'Here\Tinder\Controller' => __DIR__ . '/controller',
            'Here\Tinder\Library' => __DIR__ . '/library'
        ])->register();
    }
}
