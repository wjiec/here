<?php
/**
 * EnumInterface.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Ext\Enum;


/**
 * Interface EnumInterface
 * @package Here\Lib\Ext\Enum
 */
interface EnumInterface {
    /**
     * @return array
     */
    public static function get_constants(): array;

    /**
     * @return string
     */
    public function name(): string;

    /**
     * @return mixed
     */
    public function value();
}
