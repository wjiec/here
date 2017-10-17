<?php
/**
 * BooleanValidator.php
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
 * Class BooleanValidator
 * @package Here\Lib\Io\Filter\Validator
 */
final class BooleanValidator extends IoFilterBase {
    /**
     * @see IoFilterBase::apply()
     * @param string $object
     * @param mixed $default
     * @return bool|null
     */
    final public function apply($object, $default = false) {
        $this->default = $default;
        return filter_var($object, FILTER_VALIDATE_BOOLEAN, $this->get_options());
    }
}
