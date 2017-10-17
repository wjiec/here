<?php
/**
 * FloatValidator.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Io\Filter\Validator;
use Here\Lib\Io\Filter\IoFilterBase;


/**
 * Class FloatValidator
 * @package Here\Lib\Io\Filter\Validator
 */
final class FloatValidator extends IoFilterBase {
    /**
     * FloatValidator constructor.
     */
    final public function __construct(/* $decimal */) {
        // FILTER_VALIDATE_FLOAT, decimal option mean decimal notation['.', ','].
    }

    /**
     * @see IoFilterBase::apply()
     * @param string|mixed $object
     * @param null|mixed $default
     * @return bool|mixed
     */
    final public function apply($object, $default = false) {
        $this->default = $default;
        return filter_var($object, FILTER_VALIDATE_FLOAT, $this->get_options());
    }
}
