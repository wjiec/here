<?php
/**
 * This file is part of here
 *
 * @copyright Copyright (C) 2020 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/wjiec/here
 */
return [
    Here\Provider\Administrator\ServiceProvider::class,
    Here\Provider\Avatar\ServiceProvider::class,
    Here\Provider\Color\ServiceProvider::class,
    Here\Provider\Cookies\ServiceProvider::class,
    Here\Provider\Field\ServiceProvider::class,
    Here\Provider\Limiter\ServiceProvider::class,
    Here\Provider\Markdown\ServiceProvider::class,
    Here\Provider\Menu\ServiceProvider::class,
    Here\Provider\Pager\ServiceProvider::class,
    Here\Provider\Router\ServiceProvider::class,
    // @TODO redis adapter
    Here\Provider\Session\ServiceProvider::class,
    Here\Provider\Timezone\ServiceProvider::class,
//    Here\Provider\ViewCache\ServiceProvider::class,
    Here\Provider\VoltExtension\ServiceProvider::class,
    Here\Provider\Welcome\ServiceProvider::class,
];
