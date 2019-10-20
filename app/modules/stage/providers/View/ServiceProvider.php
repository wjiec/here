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
namespace Here\Stage\Providers\View;

use Here\Libraries\Listener\Adapter\View as ViewListener;
use Here\Providers\AbstractServiceProvider;
use Phalcon\Mvc\View;


/**
 * Class ServiceProvider
 * @package Here\Stage\Providers\View
 */
final class ServiceProvider extends AbstractServiceProvider {

    /**
     * Name of service
     *
     * @var string
     */
    protected $service_name = 'view';

    /**
     * @inheritDoc
     */
    final public function register() {
        $this->di->setShared($this->service_name, function() {
            $view = new View();
            $config = container('moduleMeta', 'stage');

            $view->setViewsDir($config->viewDir);
            if (isset($config->layoutDir)) {
                $view->setLayoutsDir($config->layoutDir);
            }

            $view->registerEngines(array(
                '.volt' => container('volt', $view, $this)
            ));

            $eventsManager = container('eventsManager');
            $view->setEventsManager($eventsManager);
            $eventsManager->attach('view', new ViewListener());

            return $view;
        });
    }

}
