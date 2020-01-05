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
