<?php
/**
 * This file is part of here
 *
 * @noinspection PhpUnused
 *
 * @copyright Copyright (C) 2020 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/wjiec/here
 */
namespace Here\Tinder\Controller;

use Bops\Mvc\Controller\AbstractErrorController;
use Throwable;


/**
 * Class ErrorController
 *
 * @package Here\Tinder\Controller
 */
class ErrorController extends AbstractErrorController {

    public function internalAction(Throwable $e) {
        $this->view->setVar('error_message', $e->getMessage());
        $this->view->setVar('error_trace', $e->getTraceAsString());
    }

    public function notFoundAction() {
        echo '<pre>';
        var_dump(container('router')); die();
    }

}
