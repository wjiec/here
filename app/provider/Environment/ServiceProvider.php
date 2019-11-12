<?php
/**
 * here application
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.org>
 * @copyright Copyright (C) 2016-2019 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/lsalio/here
 */
namespace Here\Provider\Environment;

use Here\Library\Bootstrap;
use Here\Provider\AbstractServiceProvider;


/**
 * Class ServiceProvider
 * @package Here\Provider\Environment
 */
final class ServiceProvider extends AbstractServiceProvider {

    /**
     * Name of the service
     *
     * @var string
     */
    protected $service_name = 'environment';

    /**
     * @inheritDoc
     */
    final public function register() {
        /* @var $bootstrap Bootstrap */
        $bootstrap = $this->di->getShared('bootstrap');
        $this->di->set($this->service_name, function() use ($bootstrap) {
            $environment = $bootstrap->getEnvironment();
            if (func_num_args() !== 0) {
                foreach (func_get_args() as $arg) {
                    if ($arg === $environment) {
                        return true;
                    }
                }
                return false;
            }
            return $environment;
        });
    }

}
