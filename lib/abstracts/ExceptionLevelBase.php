<?php
/**
 * ExceptionLevel.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Abstracts;


/**
 * Trait ExceptionLevelBase
 * @package Here\Lib\Abstracts
 */
trait ExceptionLevelBase {
    /**
     * @return int
     */
    abstract public function get_level();

    /**
     * @return string
     */
    abstract public function get_level_name();
}
