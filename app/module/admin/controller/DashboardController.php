<?php
/**
 * This file is part of here
 *
 * @copyright Copyright (C) 2020 Jayson Wang
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
