<?php
/**
 * here application
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.org>
 * @copyright Copyright (C) 2016-2019 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/wjiec/here
 */
namespace Here\Provider\Welcome;

use Here\Provider\AbstractServiceProvider;


/**
 * Class ServiceProvider
 * @package Here\Provider\Welcome
 */
class ServiceProvider extends AbstractServiceProvider {

    /**
     * The name of the service
     *
     * @var string
     */
    protected $service_name = 'welcome';

    /**
     * @inheritDoc
     */
    public function register() {
        $this->di->set($this->service_name, function(string $timezone = '') {
            if (!$timezone) {
                $timezone = container('config')->timezone->default;
            }

            return new Welcome($timezone);
        });
    }

}
