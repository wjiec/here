<?php
/**
 * BooleanString.php
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Env;
use Here\Lib\Ext\Enum\EnumType;


/**
 * Class BooleanString
 * @package Here\Lib\Env
 */
final class BooleanString extends EnumType {
    /**
     * yes => true
     */
    public const BOOLEAN_STRING_YES = true;

    /**
     * yes => false
     */
    public const BOOLEAN_STRING_NO = false;

    /**
     * on => true
     */
    public const BOOLEAN_STRING_ON = true;

    /**
     * off => false
     */
    public const BOOLEAN_STRING_OFF = false;

    /**
     * true => true
     */
    public const BOOLEAN_STRING_TRUE = true;

    /**
     * false => false
     */
    public const BOOLEAN_STRING_FALSE = false;

    /**
     * @param string $value
     * @return bool
     */
    final public static function is_true(?string $value): bool {
        $value = strtoupper($value ?? '');
        $boolean_string = self::get_constants();

        $key = "BOOLEAN_STRING_$value";
        return isset($boolean_string[$key]);
    }

    /**
     * @param string $value
     * @return bool
     */
    final public static function is_false(string $value): bool {
        return !self::is_true($value);
    }
}
