<?php
/**
 * This file is part of here
 *
 * @copyright Copyright (C) 2020 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/wjiec/here
 */
namespace Here\Tinder\Controller;

use Here\Tinder\Library\Mvc\Controller\AbstractController;


/**
 * Class ErrorController
 * @package Here\Tinder\Controller
 */
class ErrorController extends AbstractController {

    /**
     * Hooks on the anything found on router
     */
    public function notFoundAction() {
        $this->response->setStatusCode(404);
    }

}
