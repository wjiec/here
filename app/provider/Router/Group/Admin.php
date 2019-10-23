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
namespace Here\Provider\Router\Group;

use Phalcon\Mvc\Router\Group as RouteGroup;


/**
 * Class Admin
 * @package Here\Provider\Router\Group
 */
final class Admin extends RouteGroup {

    /**
     * Route group of admin module,
     */
    final public function initialize() {
        $this->setPaths(array('module' => 'admin'));
        $this->setPrefix(env('ADMIN_PREFIX', '/admin'));

        $this->addDashboard();
    }

    /**
     * The purpose of these rules is shows something states
     * or something to do, like review comments.
     */
    final private function addDashboard() {
        $this->addGet('[/]{0,1}(dashboard){0,1}', array('controller' => 'dashboard'))
            ->setName('dashboard');
    }

}
