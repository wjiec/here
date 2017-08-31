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
namespace Here\Lib\Exceptions\Level;
use Here\Lib\Abstracts\ExceptionLevelBase;


/**
 * Class Fatal
 * @package Here\Lib\Exception\Level
 */
trait Fatal {
    use ExceptionLevelBase;

    /**
     * @see ExceptionLevelBase::get_level()
     * @return int
     */
    public function get_level() {
        return 100;
    }

    /**
     * @see ExceptionLevelBase::get_level_name()
     * @return string
     */
    public function get_level_name() {
        return 'Fatal';
    }
}
