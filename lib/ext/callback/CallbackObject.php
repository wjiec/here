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
     * CallbackObject constructor.
     * @param callable $callback
     * @throws CallbackInvalid
     */
    final public function __construct($callback) {
        if (!is_callable($callback)) {
            throw new CallbackInvalid("callback is not callable");
        }
        $this->_callback = $callback;
    }

    /**
     * @return callable
     */
    final public function get_callback() {
        return $this->_callback;
    }

    /**
     * @param array ...$arg
     * @return mixed
     */
    final public function call(...$arg) {
        return call_user_func_array($this->_callback, $arg);
    }
}
