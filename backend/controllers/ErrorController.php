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
     * when internal error occurs
     * @param null|string $error
     * @param int|null $error_code
     */
    final public function internalAction(?string $error = null, ?int $error_code = null) {
        $this->makeResponse(self::STATUS_FATAL_ERROR,
            APPLICATION_ENV === DEVELOPMENT_ENV ? $error : 'Server Internal Error / Resource Not Exists');
        $this->terminalByStatusCode($error_code ?? 500);
    }

}
