<?php
/**
 * here application
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.org>
 * @copyright Copyright (C) 2016-2019 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/lsalio/here
 */
namespace Here\Library\Listener\Adapter;

use Here\Library\Listener\AbstractListener;
use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher as MvcDispatcher;
use Throwable;


/**
 * Class Dispatcher
 * @package Here\Library\Listener\Adapter
 */
final class Dispatcher extends AbstractListener {

    /**
     * Triggered before the dispatcher throws any exception
     *
     * @param Event $event
     * @param MvcDispatcher $dispatcher
     * @param Throwable $exception
     */
    final public function beforeException(Event $event, MvcDispatcher $dispatcher, Throwable $exception) {
        var_dump(__CLASS__, $exception); die();
    }

}
