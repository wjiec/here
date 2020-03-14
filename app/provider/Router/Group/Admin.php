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
namespace Here\Provider\Router\Group;

use Phalcon\Mvc\Router\Group as RouteGroup;


/**
 * Class Admin
 * @package Here\Provider\Router\Group
 */
class Admin extends RouteGroup {

    /**
     * Route group of admin module
     */
    public function initialize() {
        $this->setPaths(['module' => 'admin']);
        $this->setPrefix(env('ADMIN_PREFIX', '/admin'));

        $this->addDashboard();
        $this->addSetupWizard();
        $this->addSetupComplete();
        $this->addLogin();
    }

    /**
     * The purpose of these rules is shows something states
     * or something to do, like review comments and so on
     */
    protected function addDashboard() {
        $this->addGet('', ['controller' => 'dashboard'])
            ->setName('dashboard');
        $this->addGet('/dashboard', ['controller' => 'dashboard'])
            ->setName('dashboard');
    }

    /**
     * The purpose of these rules is create new administrator
     */
    protected function addSetupWizard() {
        $this->addGet('/setup', ['controller' => 'setup'])
            ->setName('setup-wizard');
    }

    /**
     * The rules is register the administrator and
     * initializing something default fields
     */
    protected function addSetupComplete() {
        $this->addPost('/setup/complete', ['controller' => 'setup', 'action' => 'complete'])
            ->setName('setup-complete');
    }

    /**
     * Login/logout page and verify login is correct
     */
    protected function addLogin() {
        $this->_addRoute('/login', ['controller' => 'login'], ['GET', 'POST'])
            ->setName('login');
        $this->addPost('/logout', ['controller' => 'logout'])
            ->setName('logout');
    }

}
