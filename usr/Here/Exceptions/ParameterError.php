<?php
/**
 * Here Exceptions definition
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */


/**
 * Exception: ParameterError
 *
 * Parameter Type Error
 * Parameter Value Error
 */
class Here_Exceptions_ParameterError extends Here_Exceptions_Base {
    /**
     * Here_Exceptions_ParameterError constructor.
     *
     * @param string $message
     * @param string $code
     * @param null $previous
     */
    public function __construct($message, $code, $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
