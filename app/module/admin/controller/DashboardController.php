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
namespace Here\Admin\Controller;

use Phalcon\Mvc\Controller;


/**
 * Class DashboardController
 * @package Here\Admin\Controller
 */
final class DashboardController extends Controller {

    /**
     * Initializing the states of dashboard
     */
    final public function initialize() {
        $this->tag->setTitle("Dashboard");
    }

    /**
     * Shows the dashboard to the admin of blog
     */
    final public function indexAction() {}

}
