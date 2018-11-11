<?php
/**
 * SessionController.php
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.org>
 * @copyright Copyright (C) 2016-2018 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Controllers;


/**
 * Class SessionController
 * @package Here\Controllers
 */
final class SessionController extends ControllerBase {

    /**
     * create an admin session
     */
    final public function createAction() {
        var_dump($this->request->getRawBody());
    }

}
