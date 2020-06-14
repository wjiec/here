<?php
/**
 * This file is part of here
 *
 * @copyright Copyright (C) 2020 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/wjiec/here
 */
namespace Here\Provider\Blogger;

use Bops\Provider\AbstractServiceProvider;
use Here\Model\Author;


/**
 * Class ServiceProvider
 *
 * @package Here\Provider\Blogger
 */
class ServiceProvider extends AbstractServiceProvider {

    /**
     * Name of the service
     *
     * @return string
     */
    public function name(): string {
        return 'blogger';
    }

    /**
     * Register the service
     *
     * @return void
     */
    public function register() {
        $this->di->setShared($this->name(), function() {
            return container('field')->get("here.blogger", function() {
                return Author::findFirst();
            });
        });
    }

}
