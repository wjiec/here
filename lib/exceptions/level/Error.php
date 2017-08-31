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
namespace Here\Lib\Exceptions\Level;
use Here\Lib\Abstracts\ExceptionLevelBase;


/**
 * Trait Error
 * @package Here\Lib\Exception\Level
 */
trait Error {
    use ExceptionLevelBase;

    /**
     * @see ExceptionLevelBase::get_level()
     * @return int
     */
    public function get_level() {
        return 80;
    }

    /**
     * @see ExceptionLevelBase::get_level_name()
     * @return string
     */
    public function get_level_name() {
        return 'Error';
    }
}
