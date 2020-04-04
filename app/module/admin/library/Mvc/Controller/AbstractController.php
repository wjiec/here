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
use Here\Library\Mvc\Controller\AbstractController as MvcAbstractController;


/**
 * Class AbstractController
 * @package Here\Admin\Library\Mvc\Controller
 */
abstract class AbstractController extends MvcAbstractController {

    /**
     * Check administrator has login
     *
     * @throws Exception
     */
    public function initialize() {
        parent::initialize();
        if (!$this->administrator->loginFromToken()) {
            if ($this->dispatcher->getControllerName() !== 'login') {
                $this->response->redirect(['for' => 'login']);
                $this->response->send();
            }
        }
    }

}
