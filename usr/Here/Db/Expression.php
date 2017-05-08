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
     * key callback
     *
     * @var callable
     */
    private $_key_callback;

    /**
     *value callback
     *
     * @var callable
     */
    private $_value_callback = null;

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
     * @throws Here_Exceptions_ParameterError
     * @return string
     */
    public function build($key_callback = null, $value_callback = null) {
        if (!is_callable($key_callback)) {
            if ($this->_key_callback == null) {
                throw new Here_Exceptions_ParameterError("must be specify key callback",
                    'Here:Db:Expression:build');
            } else {
                $key_callback = $this->_key_callback;
            }
        }

        if (!is_callable($value_callback)) {
            if ($this->_value_callback == null) {
                throw new Here_Exceptions_ParameterError("must be specify key callback",
                    'Here:Db:Expression:build');
            } else {
                $value_callback = $this->_value_callback;
            }
        }

        // execute callback
        $key = $key_callback($this->_field_name);
        $value = $value_callback($this->_value);
        // build
        return "{$key} {$this->_operator} {$value}";
    }

    /**
     * pre bind callback
     *
     * @param callable $key
     * @param callable $value
     * @return $this
     * @throws Here_Exceptions_ParameterError
     */
    public function callback($key, $value) {
        if (!is_callable($key) || !is_callable($value)) {
            throw new Here_Exceptions_ParameterError("parameters except callback",
                'Here:Db:Expression:callback');
        }

        $this->_key_callback = $key;
        $this->_value_callback = $value;

        return $this;
    }
}
