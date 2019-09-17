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
namespace Here\Libraries\Exceptions\Handlers;

use Whoops\Handler\Handler;


/**
 * Class LoggerHandler
 * @package Here\Libraries\Exceptions\Handlers
 */
final class LoggerHandler extends Handler {

    /**
     * @inheritDoc
     */
    final public function handle() {
        return self::DONE;
    }

}
