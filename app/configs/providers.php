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
return array(
    Here\Providers\Config\ServiceProvider::class,
    Here\Providers\FileSystem\ServiceProvider::class,
    Here\Providers\UrlResolver\ServiceProvider::class,
    Here\Providers\Session\ServiceProvider::class,
);
