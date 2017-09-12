<?php
/**
 * Created by PhpStorm.
 * User: ShadowMan
 * Date: 2017/9/2
 * Time: 17:03
 */
namespace Here\Lib\Exceptions\Level;


/**
 * Trait Warning
 * @package Here\Lib\Exceptions\Level
 */
trait Warning {
    use ExceptionLevelBase;

    /**
     * @see ExceptionLevelBase::get_level()
     * @return int
     */
    final public function get_level() {
        return 50;
    }

    /**
     * @see ExceptionLevelBase::get_level_name()
     * @return string
     */
    final public function get_level_name() {
        return 'Warning';
    }
}
