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
namespace Here\Provider;


/**
 * Class ServiceProviderInstaller
 * @package Here\Provider
 */
final class ServiceProviderInstaller {

    /**
     * Install and setup provider
     *
     * @param ServiceProviderInterface $provider
     */
    final public static function setup(ServiceProviderInterface $provider) {
        $provider->register();
        $provider->initialize();
    }

}
