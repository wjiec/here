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


/**
 * Class ErrorController
 *
 * @package Here\Tinder\Controller
 */
class ErrorController extends AbstractErrorController {

    public function notFoundAction() {
        echo '<pre>';
        var_dump(container('router')); die();
    }

}
