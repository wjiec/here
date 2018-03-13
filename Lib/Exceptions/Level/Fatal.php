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


/**
 * Class Fatal
 * @package Here\Lib\Exception\Level
 */
trait Fatal {
    use ExceptionLevelTrait;

    /**
     * @see ExceptionLevelTrait::get_level()
     * @return int
     */
    final public function get_level(): int {
        return 100;
    }

    /**
     * @see ExceptionLevelTrait::get_level_name()
     * @return string
     */
    final public function get_level_name(): string {
        return 'Fatal';
    }
}
