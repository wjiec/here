<?php
/**
 * This file is part of here
 *
 * @copyright Copyright (C) 2020 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/wjiec/here
 */
namespace Here\Provider\Markdown;

use Bops\Provider\AbstractServiceProvider;
use Parsedown;


/**
 * Class ServiceProvider
 * @package Here\Provider\Markdown
 */
class ServiceProvider extends AbstractServiceProvider {

    /**
     * Name of the service
     *
     * @return string
     */
    public function name(): string {
        return 'markdown';
    }

    /**
     * @inheritDoc
     */
    public function register() {
        $this->di->set($this->name(), function() {
            return new Parsedown();
        });
    }

}
