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
namespace Here\Providers\Router;

use Here\Providers\AbstractServiceProvider;
use Phalcon\Mvc\Router;


/**
 * Class ServiceProvider
 * @package Here\Providers\Router
 */
final class ServiceProvider extends AbstractServiceProvider {

    /**
     * Name of service
     *
     * @var string
     */
    protected $service_name = 'router';

    /**
     * @inheritDoc
     */
    final public function register() {
        $this->di->setShared($this->service_name, function() {
            /** @noinspection PhpIncludeInspection */
            $router = include config_path('routes.php');

            /* @var Router $router */
            if (!isset($_GET['_url'])) {
                $router->setUriSource(Router::URI_SOURCE_SERVER_REQUEST_URI);
            }

            $router->removeExtraSlashes(true);
            $router->setEventsManager(container('eventsManager'));
            $router->notFound(array(
                'module' => 'stage',
                'controller' => 'error',
                'action' => 'error404'
            ));

            return $router;
        });
    }

}
