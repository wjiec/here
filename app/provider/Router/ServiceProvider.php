<?php
/**
 * here application
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.org>
 * @copyright Copyright (C) 2016-2019 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/wjiec/here
 */
namespace Here\Provider\Router;

use Here\Library\Listener\Adapter\Router as RouterListener;
use Here\Provider\AbstractServiceProvider;
use Here\Provider\Router\Group\Admin;
use Here\Provider\Router\Group\Tinder;
use Here\Provider\Router\Hook\Hook;


/**
 * Class ServiceProvider
 * @package Here\Provider\Router
 */
final class ServiceProvider extends AbstractServiceProvider {

    /**
     * Name of the service
     *
     * @var string
     */
    protected $service_name = 'router';

    /**
     * @inheritDoc
     */
    final public function register() {
        $this->di->setShared($this->service_name, function() {
            $router = new Router();
            if (!isset($_GET['_url'])) {
                $router->setUriSource(Router::URI_SOURCE_SERVER_REQUEST_URI);
            }

            $router->removeExtraSlashes(true);
            $router->setEventsManager(container('eventsManager'));
            container('eventsManager')->attach('router', new RouterListener());

            $router->mount(new Admin());
            $router->mount(new Tinder());
            Hook::hook($router);

            return $router;
        });
    }

}
