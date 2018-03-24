<?php
/**
 * Nothing.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Exceptions\Level;


/**
 * Trait Nothing
 * @package Here\Lib\Exceptions\Level
 */
trait Nothing {
    use ExceptionLevelTrait;

    /**
     * @return int
     */
    final public function get_level(): int {
        return -1;
    }

    /**
     * @return string
     */
    final public function get_level_name(): string {
        return 'Nothing';
    }
}
