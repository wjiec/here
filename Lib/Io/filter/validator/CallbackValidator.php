<?php
/**
 * CallbackValidator.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Io\Filter\Validator;
use Here\Lib\Io\Filter\IoFilterBase;
use Here\Lib\Ext\Callback\CallbackObject;
use Here\Lib\Ext\Callback\CallbackInvalid;


/**
 * Class CallbackValidator
 * @package Here\Lib\Io\Filter\Validator
 */
final class CallbackValidator extends IoFilterBase {
    /**
     * CallbackValidator constructor.
     * @param CallbackObject $callback
     * @throws CallbackInvalid
     */
    final public function __construct(CallbackObject $callback) {
        $this->_callback = $callback;
        if ($this->_callback->get_args_count() !== 1) {
            throw new CallbackInvalid("callback object except 1 arg, got 0");
        }
    }

    /**
     * @param string $object
     * @param bool $default
     * @return mixed
     */
    final public function apply($object, $default = false) {
        return filter_var($object, FILTER_CALLBACK, array('options' => $this->_callback->get_callback()));
    }
}
