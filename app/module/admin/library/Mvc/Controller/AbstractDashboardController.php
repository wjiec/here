<?php
/**
 * This file is part of here
 *
 * @copyright Copyright (C) 2020 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/wjiec/here
 */
namespace Here\Admin\Library\Mvc\Controller;

use Exception;


/**
 * Class AbstractDashboardController
 * @package Here\Admin\Library\Mvc\Controller
 */
abstract class AbstractDashboardController extends AbstractController {

    /**
     * Add menu layout into view
     *
     * @throws Exception
     */
    public function initialize() {
        parent::initialize();

        $this->view->setTemplateAfter('layout');
    }

}
