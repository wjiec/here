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
use Here\Library\Field\Store\Adapter\Cache;
use Here\Library\Field\Store\Adapter\Composition;
use Here\Library\Field\Store\Adapter\Database;
use Here\Library\Field\Store\Adapter\Memory;


/**
 * Class ServiceProvider
 *
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
     * Register the service
     *
     * @return void
     */
    public function register() {
        $memory = new Memory();
        $this->di->setShared("{$this->name()}.memory", $memory);

        $cache = new Cache(container('cache'));
        $this->di->setShared("{$this->name()}.cache", $cache);

        $database = new Database();
        $this->di->setShared("{$this->name()}.db", $database);

        $composition = new Composition($memory, $cache, $database);
        $this->di->setShared($this->name(), $composition);
    }

}
