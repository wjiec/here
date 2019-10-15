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
namespace Here\Providers;


/**
 * Class ServiceProviderInstaller
 * @package Here\Providers
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
