<?php
/**
 * EnumTypeBase.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Ext\Enum;


/**
 * Class EnumTypeBase
 * @package Here\Lib\Ext\Enum
 */
abstract class EnumTypeBase implements EnumInterface {
    /**
     * @var array
     */
    private static $_constants;

    /**
     * @return array
     */
    public static function get_constants(): array {
        if (self::$_constants === null) {
            $ref = new \ReflectionClass(get_called_class());
            self::$_constants = $ref->getConstants();
        }

        return self::$_constants;
    }
}
