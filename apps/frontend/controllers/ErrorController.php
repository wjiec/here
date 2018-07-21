<?php
/**
 * ErrorController.php
 *
 * @package   here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Frontend\Controllers;


use Here\Controllers\ControllerBase;


/**
 * Class ErrorController
 * @package Here\Frontend\Controllers
 */
final class ErrorController extends ControllerBase {

    /**
     * http 5xx error
     */
    final public function internalErrorAction() {
        $error_message = $this->dispatcher->getParam('message');
        $error_context = $this->dispatcher->getParam('context');

        var_dump($error_context);
        var_dump($error_message);
    }

}
