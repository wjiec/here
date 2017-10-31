<?php
/**
 * Enum.php
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
abstract class EnumType extends EnumTypeBase {
    /**
     * key name of constant default value
     */
    private const ENUM_DEFAULT_KEY = '__default';

    /**
     * @var null|mixed
     */
    private $_current_value;

    /**
     * default value for enum type
     */
    public const __default = null;

    /**
     * Enum constructor.
     * @param null $initial_value
     */
    final public function __construct($initial_value = self::__default) {
        $this->_current_value = $initial_value
            ?? self::get_constants()[self::ENUM_DEFAULT_KEY];
    }

    /**
     * @return int|null|string
     */
    final public function name() {
        $enum_type_name = null;

        foreach (self::get_constants() as $name => $value) {
            if ($value === $this->_current_value && $name !== self::ENUM_DEFAULT_KEY) {
                $enum_type_name = $name;
            }
        }

        return $enum_type_name ?? self::ENUM_DEFAULT_KEY;
    }

    /**
     * @return mixed|null
     */
    final public function value() {
        return $this->_current_value;
    }
}
