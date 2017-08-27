<?php
/**
 * Fatal.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Exception\Level;
use Here\Lib\Abstracts\ExceptionLevel;


/**
 * Class Fatal
 * @package Here\Lib\Exception\Level
 */
final class Fatal extends ExceptionLevel {
    /**
     * @see ExceptionLevel::_level()
     */
    final protected function _level() {
        return 100;
    }

    /**
     * @see ExceptionLevel::_name()
     */
    final protected function _name() {
        return __CLASS__;
    }
}
