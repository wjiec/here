<?php
/**
 * CallbackObjectObject.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Ext\Callback;


/**
 * Class CallbackObject
 * @package Here\Lib\Ext\CallbackObject
 */
class CallbackObject {
    /**
     * @var callable
     */
    private $_callback;

    /**
     * @var int
     */
    private $_args_count = 0;

    /**
     * @var array
     */
    private $_args_names = array();

    /**
     * @var array
     */
    private $_args_default = array();

    /**
     * CallbackObject constructor.
     * @param $callback
     * @throws InvalidCallback
     */
    final public function __construct($callback) {
        $this->_callback = $callback;
        $this->_reflection();
    }

    /**
     * @return int
     */
    final public function get_args_count(): int {
        return $this->_args_count;
    }

    /**
     * @param array ...$args
     * @return mixed
     * @throws \ArgumentCountError
     */
    final public function apply(...$args) {
        $require_arg_count = $this->_args_count - count($this->_args_default);
        if (count($args) < $require_arg_count) {
            $pass_count = count($args);
            throw new \ArgumentCountError("Too few arguments to `CallbackObject` " .
                "{$pass_count} passed and exactly {$require_arg_count} expected");
        }

        // build all arguments
        $complete_args = array_pad(array(), $require_arg_count, null);
        foreach ($this->_args_default as $default_value) {
            $complete_args[] = $default_value;
        }

        // override user arguments
        foreach ($args as $index => $arg) {
            $complete_args[$index] = $arg;
        }

        return call_user_func_array($this->_callback, $complete_args);
    }

    /**
     * @throws InvalidCallback
     */
    final private function _reflection(): void {
        if (is_array($this->_callback)) {
            $ref = new \ReflectionMethod(...$this->_callback);
        } else if (is_string($this->_callback)) {
            $ref = new \ReflectionFunction($this->_callback);
        } else {
            throw new InvalidCallback("invalid callback");
        }

        $this->_args_count = $ref->getNumberOfParameters();
        foreach ($ref->getParameters() as $param) {
            $this->_args_names[] = $param->name;
            if ($param->isOptional()) {
                $this->_args_default[] = $param->getDefaultValue();
            }
        }
    }
}
