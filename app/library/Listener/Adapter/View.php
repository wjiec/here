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
use Phalcon\Mvc\ViewBaseInterface;


/**
 * Class View
 * @package Here\Library\Listener\Adapter
 */
final class View extends AbstractListener {

    /**
     * Notify about not found views
     *
     * @noinspection PhpUnused
     * @param Event $event
     * @param ViewBaseInterface $view
     * @param string $engine_path
     *
     */
    final public function notFoundView(Event $event, ViewBaseInterface $view, string $engine_path) {
        // @TODO logger on not found
        if ($event->isCancelable()) {
            $event->stop();
        }
    }

}
