<?php
/**
 * EmailValidator.php
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
 * Class EmailValidator
 * @package Here\Lib\Io\Filter
 */
class EmailValidator extends IoFilterBase {
    /**
     * @see IoFilterInterface::apply()
     * @param string $object
     * @param mixed|null $default
     * @return mixed|string
     */
    final public function apply($object, $default = null) {
        return filter_var($object, FILTER_VALIDATE_EMAIL) ?: $default;
    }
}
