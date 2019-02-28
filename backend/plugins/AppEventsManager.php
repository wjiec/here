<?php
/**
 * AppEventsManager
 *
 * @package   Here
 * @author    Jayson Wang <jayson@laboys.org>
 * @copyright Copyright (C) 2016-2018 Jayson Wang
 */
namespace Here\Plugins;


use Here\Libraries\Hunter\ErrorCatcher;
use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Mvc\Dispatcher;


/**
 * Class AppEventsManager
 * @package Here\plugins
 */
final class AppEventsManager extends EventsManager {

    /**
     * AppEventsManager constructor.
     * initializing something events and prepare ErrorHunter
     */
    final public function __construct() {
        // on dispatcher exception occurs before
        $this->attach('dispatch:beforeException', function(...$args) {
            return $this->onBeforeException(...$args);
        });
    }

    /**
     * @param Event $event
     * @param Dispatcher $dispatcher
     * @param \Exception $exception
     * @return bool
     * @throws \Exception
     */
    final private function onBeforeException(Event $event, Dispatcher $dispatcher, \Exception $exception) {
        switch ($exception->getCode()) {
            case Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
            case Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
            case Dispatcher::EXCEPTION_INVALID_HANDLER:
                // error logging
                ErrorCatcher::triggerException($exception);
                // report an error to client
                $dispatcher->forward(array(
                    'controller' => 'error',
                    'action' => 'internal',
                    'params' => array($exception->getMessage(), 404)
                ));
                return false;
        }
        return true;
    }

}
