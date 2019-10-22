<?php
/**
 * here application
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.org>
 * @copyright Copyright (C) 2016-2019 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/nosjay/here
 */
namespace Here\Provider\Field;

use Here\Provider\Field\Store\Adapter\Cache;
use Here\Provider\Field\Store\Adapter\Database;
use Here\Provider\Field\Store\Adapter\Memory;
use Here\Provider\Field\Store\Adapter\Mixed;
use Here\Provider\AbstractServiceProvider;


/**
 * Class ServiceProvider
 * @package Here\Provider\Field
 */
final class ServiceProvider extends AbstractServiceProvider {

    /**
     * Name of the service
     *
     * @var string
     */
    protected $service_name = 'field';

    /**
     * @inheritdoc
     */
    final public function register() {
        $this->di->set($this->service_name, function() {
            return new Mixed(new Memory(), new Cache(), new Database());
        });
    }

}
