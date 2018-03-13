<?php
/**
 * MacAddrValidator.phpor.php
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
 * Class MacAddrValidator
 * @package Here\Lib\Io\Filter\Validator
 */
final class MacAddrValidator extends IoFilterBase {
    /**
     * @see IoFilterBase::apply()
     * @param string $object
     * @param bool $default
     * @return mixed
     */
    final public function apply($object, $default = false) {
        $this->default = $default;
        return filter_var($object, FILTER_VALIDATE_MAC, $this->get_options());
    }
}
