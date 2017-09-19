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
use Here\Lib\Ext\Callback\CallbackObject;
use Here\Lib\Io\Filter\IoFilterBase;


/**
 * Class CallbackValidator
 * @package Here\Lib\Io\Filter\Validator
 */
final class CallbackValidator extends IoFilterBase {
    /**
     * CallbackValidator constructor.
     * @param CallbackObject $callback
     */
    final public function __construct(CallbackObject $callback) {
        $this->_callback = $callback;
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
