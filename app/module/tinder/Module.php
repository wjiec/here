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
 * @package Here\Tinder
 */
final class Module extends AbstractModule {

    /**
     * Registers an autoloader related to the module
     *
     * @param DiInterface|null $di
     */
    final public function registerAutoloaders(DiInterface $di = null) {
        (new Loader())->registerNamespaces([
            'Here\Tinder' => __DIR__,
            'Here\Tinder\Controller' => __DIR__ . DIRECTORY_SEPARATOR . 'controller',
            'Here\Tinder\Library' => __DIR__ . DIRECTORY_SEPARATOR . 'library',
            'Here\Tinder\Provider' => __DIR__ . DIRECTORY_SEPARATOR . 'provider'
        ])->register();
    }


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
     * Returns an array of the config module filename without extname
     *
     * @return array
     */
    protected function configModules(): array {
        return [];
    }

}
