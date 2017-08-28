<?php
/**
 * Error.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Exception\Level;
use Here\Lib\Abstracts\ExceptionLevelBase;


class Error extends ExceptionLevelBase {
    /**
     * @see ExceptionLevelBase::_level()
     * @return int
     */
    protected function _level() {
        return 80;
    }

    /**
     * @see ExceptionLevelBase::_name()
     * @return string
     */
    protected function _name() {
        return 'Error';
    }
}
