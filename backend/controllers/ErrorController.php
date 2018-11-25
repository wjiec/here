<?php
/**
 * error handler and report
 *
 * @package   Here
 * @author    Jayson Wang <jayson@laboys.org>
 * @copyright Copyright (C) 2016-2018 Jayson Wang
 */
namespace Here\Controllers;


use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher\Exception;


/**
 * Class errorController
 * @package Here\Controllers
 */
final class ErrorController extends ControllerBase {

    /**
     * when controller/action not found
     * @param Event $context
     * @param string $message
     */
    final public function notFoundAction(Event $context, string $message) {
        /* @var Exception $exception */
        $exception = $context->getData();
        $this->terminalResponse(-$exception->getCode(), $message);
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
