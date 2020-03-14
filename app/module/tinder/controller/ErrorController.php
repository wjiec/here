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
