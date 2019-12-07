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
namespace Here\Admin\Controller;

use Here\Admin\Library\Mvc\Controller\AbstractController;
use Phalcon\Tag;


/**
 * Class DashboardController
 * @package Here\Admin\Controller
 */
final class DashboardController extends AbstractController {

    /**
     * Initializing the states of dashboard
     */
    final public function initialize() {
        Tag::setTitle("Dashboard");
    }

    /**
     * Shows something states or something to do
     */
    final public function indexAction() {}

}
