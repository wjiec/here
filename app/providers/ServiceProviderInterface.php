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
 * Interface ServiceProviderInterface
 * @package Here\Providers
 */
interface  ServiceProviderInterface {

    /**
     * Get the service name
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Register the service
     *
     * @return void
     */
    public function register();

    /**
     * Initializing the service
     *
     * @return void
     */
    public function initialize();

}
