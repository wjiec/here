<?php
/**
 * error handler and report
 *
 * @package   Here
 * @author    Jayson Wang <shadowman@shellboot.com>
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
     * @return \Phalcon\Http\ResponseInterface
     */
    final public function notFoundAction(Event $context, string $message) {
        /* @var Exception $exception */
        $exception = $context->getData();
        return $this->makeResponse(-$exception->getCode(), $message);
    }

}
