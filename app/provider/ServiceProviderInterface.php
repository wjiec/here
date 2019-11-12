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
 * Interface ServiceProviderInterface
 * @package Here\Provider
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
