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
namespace Here\Admin\Provider\View;

use Here\Library\Listener\Adapter\View as ViewListener;
use Here\Provider\AbstractServiceProvider;
use Phalcon\Mvc\View as MvcView;


/**
 * Class ServiceProvider
 * @package Here\Admin\Provider\View
 */
final class ServiceProvider extends AbstractServiceProvider {

    /**
     * Name of the service
     *
     * @var string
     */
    protected $service_name = 'view';

    /**
     * @inheritdoc
     */
    final public function register() {
        $this->di->setShared($this->service_name, function() {
            $view = new MvcView();

            $view->setViewsDir(module_path('admin/view'));
            $view->registerEngines(array(
                '.volt' => container('volt', $view, $this)
            ));

            $view->setEventsManager(container('eventsManager'));
            container('eventsManager')->attach('view', new ViewListener());

            return $view;
        });
    }

}
