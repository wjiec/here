<?php
/**
 * Warning.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Exceptions\Level;


/**
 * Trait Warning
 * @package Here\Lib\Exceptions\Level
 */
trait Warning {
    use ExceptionLevelTrait;

    /**
     * @see ExceptionLevelTrait::get_level()
     * @return int
     */
    final public function get_level() {
        return 50;
    }

    /**
     * @see ExceptionLevelTrait::get_level_name()
     * @return string
     */
    final public function get_level_name() {
        return 'Warning';
    }
}
