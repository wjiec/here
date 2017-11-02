<?php
/**
 * EnumType.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Ext\Enum;


/**
 * Class Enum
 * @package Here\Lib\Ext\Enum
 */
abstract class EnumType implements EnumInterface {
    /**
     * key name of constant default value
     */
    private const ENUM_DEFAULT_KEY = '__default';

    /**
     * default value for enum type
     */
    public const __default = null;

    /**
     * @var array
     */
    private static $_constants;

    /**
     * @var null|mixed
     */
    private $_current_value;

    /**
     * Enum constructor.
     * @param null $initial_value
     */
    final public function __construct($initial_value = self::__default) {
        $this->_current_value = $initial_value
            ?? self::get_constants(true)[self::ENUM_DEFAULT_KEY];
    }

    /**
     * @see EnumInterface::name()
     * @return int|null|string
     */
    final public function name(): string {
        $enum_type_name = null;

        foreach (self::get_constants() as $name => $value) {
            if ($value === $this->_current_value && $name !== self::ENUM_DEFAULT_KEY) {
                $enum_type_name = $name;
            }
        }

        return $enum_type_name ?? self::ENUM_DEFAULT_KEY;
    }

    /**
     * @see EnumInterface::value()
     * @return mixed|null
     */
    final public function value() {
        return $this->_current_value;
    }

    /**
     * @see EnumInterface::get_constants()
     * @param bool $within_default
     * @return array
     */
    public static function get_constants($within_default = false): array {
        $called_class_name = get_called_class();

        // cached constants for each classes base on `EnumType`
        if (!isset(self::$_constants[$called_class_name])) {
            $ref = new \ReflectionClass($called_class_name);
            self::$_constants[$called_class_name] = $ref->getConstants();
        }

        $constants = self::$_constants[$called_class_name];
        if (!$within_default) {
            unset($constants[self::ENUM_DEFAULT_KEY]);
        }

        return $constants;
    }
}
