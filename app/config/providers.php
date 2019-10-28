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
    Here\Provider\Application\ServiceProvider::class,
    Here\Provider\Cache\ServiceProvider::class,
    Here\Provider\Config\ServiceProvider::class,
    Here\Provider\Csrf\ServiceProvider::class,
    Here\Provider\Database\ServiceProvider::class,
    Here\Provider\Field\ServiceProvider::class,
    Here\Provider\FileSystem\ServiceProvider::class,
    Here\Provider\Logger\ServiceProvider::class,
    Here\Provider\ModuleMeta\ServiceProvider::class,
    Here\Provider\Router\ServiceProvider::class,
    Here\Provider\Session\ServiceProvider::class,
    Here\Provider\Timezone\ServiceProvider::class,
    Here\Provider\UrlResolver\ServiceProvider::class,
    Here\Provider\Volt\ServiceProvider::class,
);
