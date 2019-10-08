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

use Whoops\Handler\Handler;


/**
 * Class ErrorPageHandler
 * @package Here\Libraries\Exception\Handler
 */
final class ErrorPageHandler extends Handler {

    /**
     * @inheritDoc
     * @return int|void|null
     */
    final public function handle() {
        return self::DONE;
    }

}
