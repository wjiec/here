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
namespace Here\Provider\Application;

use Here\Admin\Module as AdminModule;
use Here\Tinder\Module as TinderModule;
use Phalcon\DiInterface;
use Phalcon\Mvc\Application as MvcApplication;


/**
 * Class Application
 * @package Here\Provider\Application
 */
final class Application extends MvcApplication {

    /**
     * Initializing the modules for application
     *
     * @param DiInterface|null $di
     */
    final public function __construct(DiInterface $di = null) {
        parent::__construct(($di ?? container()));
        $this->setEventsManager(container('eventsManager'));
        $this->setupModules();
    }

    /**
     * Setups the multi modules supported, and register all modules
     * to the application
     */
    final private function setupModules() {
        $this->registerModules([
            'admin' => [
                'path' => module_path('admin/Module.php'),
                'className' => AdminModule::class
            ],
            'tinder' => [
                'path' => module_path('tinder/Module.php'),
                'className' => TinderModule::class
            ]
        ]);
        $this->setDefaultModule('tinder');
    }

}
