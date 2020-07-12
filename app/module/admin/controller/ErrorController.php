<?php
/**
 * This file is part of here
 *
 * @copyright Copyright (C) 2020 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/wjiec/here
 */
namespace Here\Admin\Controller;

use Bops\Mvc\Controller\AbstractErrorController;


/**
 * Class ErrorController
 *
 * @package Here\Admin\Controller
 */
class ErrorController extends AbstractErrorController {

    /**
     * check blogger exists
     */
    public function notFoundAction() {
        if (!container('blogger')) {
            return $this->response->redirect(['for' => 'setup-wizard']);
        }
        return parent::notFoundAction();
    }

}
