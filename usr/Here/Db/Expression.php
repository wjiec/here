<?php
/**
 * Here Db Utils: Expression
 * 
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */


/**
 * Class Here_Db_Expression
 */
class Here_Db_Expression {
    /**
     * table field
     *
     * @var string
     */
    private $_field_name;

    /**
     * right value
     *
     * @var string|int|double|Here_Db_Function_Base
     */
    private $_value;

    /**
     * expression operator
     *
     * @var string
     */
    private $_operator;

    /**
     * Here_Db_Expression constructor.
     *
     * @param string $field_name
     * @throws Here_Exceptions_ParameterError
     */
    public function __construct($field_name) {
        if (!is_string($field_name)) {
            throw new Here_Exceptions_ParameterError("field name except string type",
                'Here:Db:Expression:__construct');
        }
        // escape ?
        $this->_field_name = $field_name;
    }

    /**
     * =$value
     *
     * @param mixed $value
     * @return $this
     */
    public function equal($value) {
        $this->_operator = '=';
        $this->_value = $value;

        return $this;
    }

    /**
     * >$value, >=$value
     *
     * @param mixed $value
     * @param bool $equal
     * @return $this
     */
    public function bigger($value, $equal = false) {
        $this->_operator = '>';
        if ($equal) {
            $this->_operator .= '=';
        }
        $this->_value = $value;

        return $this;
    }

    /**
     * <$value, <=$value
     *
     * @param mixed $value
     * @param bool $equal
     * @return $this
     */
    public function smaller($value, $equal = false) {
        $this->_operator = '<';
        if ($equal) {
            $this->_operator .= '=';
        }
        $this->_value = $value;

        return $this;
    }

    /**
     * build available expression
     *
     * @param callable|null $key_callback
     * @param callable|null $value_callback
     * @return string
     */
    public function build($key_callback, $value_callback) {
        if (is_callable($key_callback)) {
            $key = $key_callback($this->_field_name);
        } else {
            $key = $this->_field_name;
        }

        if (is_callable($value_callback)) {
            $value = $value_callback($this->_value);
        } else {
            $value = $this->_value;
        }

        return "{$key}{$this->_operator}{$value}";
    }
}
