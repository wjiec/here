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
namespace Here\Provider\Router\Group;

use Phalcon\Mvc\Router\Group as RouteGroup;


/**
 * Class Admin
 * @package Here\Provider\Router\Group
 */
final class Admin extends RouteGroup {

    /**
     * Route group of admin module
     */
    final public function initialize() {
        $this->setPaths(['module' => 'admin']);
        $this->setPrefix(env('ADMIN_PREFIX', '/admin'));

        $this->addDashboard();
        $this->addSetupWizard();
        $this->addSetupComplete();
    }

    /**
     * The purpose of these rules is shows something states
     * or something to do, like review comments and so on
     */
    final private function addDashboard() {
        $this->addGet('[/]{0,1}(dashboard){0,1}', ['controller' => 'dashboard'])
            ->setName('dashboard');
    }

    /**
     * The purpose of these rules is create new administrator
     */
    final private function addSetupWizard() {
        $this->addGet('/setup', ['controller' => 'setup'])
            ->setName('setup-wizard');
    }

    /**
     * The rules is register the administrator and
     * initializing something default fields
     */
    final private function addSetupComplete() {
        $this->addPost('/setup/complete', ['controller' => 'setup', 'action' => 'complete'])
            ->setName('setup-complete');
    }

}
