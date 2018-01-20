<?php
/**
 * ExceptionLevelTrait.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Exceptions\Level;


/**
 * Trait ExceptionLevelBase
 * @package Here\Lib\Abstracts
 */
trait ExceptionLevelTrait {
    /**
     * @return int
     */
    abstract public function get_level(): int;

    /**
     * @return string
     */
    abstract public function get_level_name(): string;
}
