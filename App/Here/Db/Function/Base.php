<?php
/**
 * Here Database Function
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */


/**
 * Abstract Class: Here_Db_Function_Base
 */
abstract class Here_Db_Function_Base {
    /**
     * current function arguments count
     *
     * @var int
     */
    protected $_function_argc;

    /**
     * current function arguments
     *
     * @var array
     */
    protected $_function_args;

    /**
     * Here_Db_Function_Base constructor.
     */
    final public function __construct(/* ... */) {
        $this->_function_args = func_get_args();
        $this->_function_argc = count($this->_function_args);
    }

    /**
     * returns the value of security available for stitching
     *
     * @return string
     */
    abstract public function __toString();
}

// @TODO database function eg. NOW() ...