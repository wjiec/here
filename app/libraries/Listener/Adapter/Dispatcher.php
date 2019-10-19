<?php
/**
 * here application
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.org>
 * @copyright Copyright (C) 2016-2019 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/nosjay/here
 */
namespace Here\Libraries\Listener\Adapter;

use Exception;
use Here\Libraries\Listener\AbstractListener;
use Phalcon\Events\Event;
use Phalcon\Http\Request;
use Phalcon\Mvc\Dispatcher as MvcDispatcher;
use Throwable;


/**
 * Class Dispatcher
 * @package Here\Libraries\Listener\Adapter
 */
final class Dispatcher extends AbstractListener {

    /**
     * @param Event $event
     * @param MvcDispatcher $dispatcher
     * @throws Exception
     */
    final public function beforeExecuteRoute(Event $event, MvcDispatcher $dispatcher) {
        /* @var $request Request */
        $request = container('request');
        if ($request->hasHeader('X-Service-Select')) {
            $service = $request->getHeader('X-Service-Select');
            if ($service !== $dispatcher->getModuleName()) {
                $dispatcher->forward(array('module' => $service));
                $dispatcher->dispatch();
            }
        }
    }

    /**
     * @param Event $event
     * @param MvcDispatcher $dispatcher
     * @param Throwable $exception
     */
    final public function beforeException(Event $event, MvcDispatcher $dispatcher, Throwable $exception) {
        var_dump($exception); die();
    }

}
