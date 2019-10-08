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
namespace Here\Libraries\Exception\Handler;

use Phalcon\Logger\AdapterInterface as LoggerInterface;
use Whoops\Handler\Handler;


/**
 * Class LoggerHandler
 * @package Here\Libraries\Exception\Handler
 */
final class LoggerHandler extends Handler {

    /**
     * @inheritDoc
     * @return int|void|null
     */
    final public function handle() {
        if ($logger = $this->getLogger()) {
            $logger->error($this->getLogContents());
        }
        return self::DONE;
    }

    /**
     * Get a logger from container
     *
     * @return LoggerInterface|null
     */
    final private function getLogger(): ?LoggerInterface {
        if (container()->has('logger')) {
            return container('logger');
        }
        return null;
    }

    /**
     * Returns contents of exception/error
     *
     * @return string
     */
    final private function getLogContents(): string {
        $exception = $this->getException();
        return sprintf("[%s:%d]%s: %s\n[StackTrace]: %s\n",
            $exception->getFile(), $exception->getLine(),
            get_class($exception), $exception->getMessage(),
            $this->getStackTrace()
        );
    }

    /**
     * Get the exception trace as plain text
     *
     * @return string
     */
    final private function getStackTrace(): string {
        $frames = $this->getInspector()->getFrames();
//        return array_reduce(, function() {
//
//        }, 0);
        return '';
    }

}
