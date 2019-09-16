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
namespace Here\Providers\Environment;

use Here\Providers\AbstractServiceProvider;


/**
 * Class ServiceProvider
 * @package Here\Providers\Environment
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
        $this->di->set($this->service_name, function(...$args) {
            $environment = $this->di->getShared('bootstrap')->getEnvironment();
            if (!empty($args)) {
                foreach ($args as $arg) {
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
