<?php
/**
 * This file is part of here
 *
 * @copyright Copyright (C) 2020 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/wjiec/here
 */
namespace Here\Provider\Router;

use Bops\Mvc\Router\Router;
use Bops\Provider\AbstractServiceProvider;
use Here\Provider\Router\Group\Admin;
use Here\Provider\Router\Group\Tinder;


/**
 * Class ServiceProvider
 * @package Here\Provider\Router
 */
final class ServiceProvider extends AbstractServiceProvider {

    /**
     * Name of the service
     *
     * @return string
     */
    public function name(): string {
        return 'router';
    }

    /**
     * @inheritDoc
     */
    final public function register() {
        /* @var Router $router */
        $router = container('router');
        $this->di->setShared($this->name(), function() use ($router) {
            if (!isset($_GET['_url'])) {
                $router->setUriSource(Router::URI_SOURCE_SERVER_REQUEST_URI);
            }

            $router->clear();
            $router->removeExtraSlashes(true);

            $router->mount(new Admin());
            $router->mount(new Tinder());

            return $router;
        });
    }

}
