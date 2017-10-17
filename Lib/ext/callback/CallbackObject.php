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
     * @param callable $callback
     * @throws CallbackInvalid
     */
    final public function __construct($callback) {
        if (!is_callable($callback)) {
            throw new CallbackInvalid("callback is not callable");
        }
        $this->_callback = $callback;
        $this->_reflection();
    }

    /**
     * @return callable
     */
    final public function get_callback() {
        return $this->_callback;
    }

    /**
     * @return int
     */
    final public function get_args_count() {
        return $this->_args_count;
    }

    /**
     * @param array ...$arg
     * @return mixed
     */
    final public function call(...$arg) {
        return call_user_func_array($this->_callback, $arg);
    }

    /**
     * reflection function
     */
    final private function _reflection() {
        $ref = new \ReflectionFunction($this->_callback);

        $this->_args_count = $ref->getNumberOfParameters();
        foreach ($ref->getParameters() as $param) {
            $this->_args_names[] = $param->name;
            if ($param->isOptional()) {
                $this->_args_default[] = $param->getDefaultValue();
            }
        }
    }
}
