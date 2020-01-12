<?php
/**
 * here application
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.org>
 * @copyright Copyright (C) 2016-2020 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/lsalio/here
 */
namespace Here\Provider\Menu;

use Here\Provider\AbstractServiceProvider;
use Phalcon\Config;


/**
 * Class ServiceProvider
 * @package Here\Provider\Menu
 */
class ServiceProvider extends AbstractServiceProvider {

    /**
     * The name of the service
     *
     * @var string
     */
    protected $service_name = 'menu';

    /**
     * @inheritDoc
     */
    public function register() {
        $this->di->setShared($this->service_name, function() {
            /** @noinspection PhpIncludeInspection */
            return new Config(include config_path('menu.php'));
        });
    }

}
