<?php
/**
 * Assert Module
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */


namespace Here\Widgets;
use Here\Exceptions\Here_Exceptions_AssertError;


/**
 * Class Here_Widget_Assert
 * @package Here\Widgets
 */
class Here_Widget_Assert extends \Here_Abstracts_Widget {
    /**
     * Here_Widget_Assert constructor.
     * @param array $options
     */
    public function __construct(array $options = array()) {
        parent::__construct($options);
        $this->set_widget_name('Assert');
    }

    /**
     * @param mixed $object
     * @throws Here_Exceptions_AssertError
     */
    public static function String($object) {
        if (!is_string($object)) {
            throw new Here_Exceptions_AssertError("StringAssert error",
                'Here:Widget:Assert:String');
        }
    }

    /**
     * @param mixed $object
     * @throws Here_Exceptions_AssertError
     */
    public static function Object($object) {
        if (!is_object($object)) {
            throw new Here_Exceptions_AssertError("ObjectAssert error",
                'Here:Widget:Assert:Object');
        }
    }

    /**
     * @param mixed $object
     * @throws Here_Exceptions_AssertError
     */
    public static function Integer($object) {
        if (!is_integer($object)) {
            throw new Here_Exceptions_AssertError("IntegerAssert error",
                'Here:Widget:Assert:Integer');
        }
    }

    /**
     * @param mixed $object
     * @throws Here_Exceptions_AssertError
     */
    public static function Double($object) {
        if (!is_double($object)) {
            throw new Here_Exceptions_AssertError("IntegerAssert error",
                'Here:Widget:Assert:Integer');
        }
    }
}
