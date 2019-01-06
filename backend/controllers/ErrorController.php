<?php
/**
 * error handler and report
 *
 * @package   Here
 * @author    Jayson Wang <jayson@laboys.org>
 * @copyright Copyright (C) 2016-2018 Jayson Wang
 */
namespace Here\Controllers;


use Here\Controllers\Base\ControllerBase;


/**
 * Class errorController
 * @package Here\Controllers
 */
final class ErrorController extends ControllerBase {

    /**
     * @param string $error
     */
    final public function exceptionAction(string $error) {
        $this->terminalResponse(self::STATUS_FATAL_ERROR,
            APPLICATION_ENV === DEVELOPMENT_ENV ? $error : 'Not Found');
    }

    /**
     * when internal error occurs
     * @param null|string $error
     */
    final public function internalAction(?string $error = null) {
        $this->terminalResponse(self::STATUS_FATAL_ERROR,
            APPLICATION_ENV === DEVELOPMENT_ENV ? $error : 'Server Internal Error');
    }

}
