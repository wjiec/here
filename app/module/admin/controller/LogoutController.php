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
use Here\Admin\Library\Mvc\Controller\AbstractController;


/**
 * Class LogoutController
 * @package Here\Admin\Controller
 */
class LogoutController extends AbstractController {

    /**
     * redirect to explore page when not login
     *
     * @throws Exception
     */
    public function initialize() {
        parent::initialize();

        if (!$this->administrator->loginFromToken()) {
            $this->response->redirect(['for' => 'explore']);
            $this->response->send();
        }
    }

    /**
     * User logout
     */
    public function indexAction() {
        if ($this->security->checkToken()) {
            $this->administrator->cleanLoginToken();
        }
        $this->response->redirect(['for' => 'explore']);
    }

}
