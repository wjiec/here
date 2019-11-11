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
namespace Here\Library\Exception\Handler;

use Phalcon\Logger\AdapterInterface as LoggerInterface;
use Whoops\Exception\Frame;
use Whoops\Handler\Handler;


/**
 * Class LoggerHandler
 * @package Here\Library\Exception\Handler
 */
final class LoggerHandler extends Handler {

    /**
     * @inheritDoc
     * @return int|null
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
        return sprintf("<%s:%d> %s: %s\n%s STACKTRACE %s\n%s",
            $exception->getFile(), $exception->getLine(),
            get_class($exception), $exception->getMessage(),
            $this->getTitleSeparator(), $this->getTitleSeparator(),
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

        $stacktrace = '';
        foreach ($frames as $index => $frame) {
            /* @var Frame $frame */
            $stacktrace .= sprintf("#%-3d <%s:%d>\t%s::%s(%s)\n",
                count($frames) - $index - 1, $frame->getFile(), $frame->getLine(), $frame->getClass(),
                $frame->getFunction(), $this->getFunctionArgs($frame)
            );
        }
        return $stacktrace;
    }

    /**
     * Get the arguments of function in the frame
     *
     * @param Frame $frame
     * @return string
     */
    final private function getFunctionArgs(Frame $frame): string {
        return join(",", array_map(function($arg) {
            switch (true) {
                case is_string($arg):   return "string{{$arg}}";
                case is_numeric($arg):  return "number{{$arg}}";
                case is_bool($arg):     return "boolean{{$arg}}";
                case is_null($arg):     return "null{null}";
                case is_object($arg):   return sprintf('object{%s}', get_class($arg));
            }
            return '???{???}';
        }, $frame->getArgs()));
    }

    /**
     * Gets the separator of the stacktrace title
     *
     * @return string
     */
    final private function getTitleSeparator(): string {
        return str_pad('', 24, '=');
    }

}
