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
namespace Here\Admin\Controller;

use Exception;
use Here\Admin\Library\Mvc\Controller\AbstractDashboardController;


/**
 * Class DashboardController
 * @package Here\Admin\Controller
 */
final class DashboardController extends AbstractDashboardController {

    /**
     * Initializing the states of dashboard
     *
     * @throws Exception
     */
    final public function initialize() {
        parent::initialize();
    }

    /**
     * Shows something states or something to do
     */
    final public function indexAction() {}

}
