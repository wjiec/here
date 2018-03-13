<?php
/**
 * RegexValidator.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Io\Filter\Validator;
use Here\Lib\Ext\Regex\Regex;
use Here\Lib\Io\Filter\IoFilterBase;


/**
 * Class RegexValidator
 * @package Here\Lib\Io\Filter\Validator
 */
final class RegexValidator extends IoFilterBase {
    /**
     * RegexValidator constructor.
     * @param Regex $regex
     */
    final public function __construct(Regex $regex) {
        $this->regexp = $regex->get_pattern();
    }

    /**
     * @see IoFilterBase::apply()
     * @param string $object
     * @param bool $default
     * @return mixed
     */
    final public function apply($object, $default = false) {
        $this->default = $default;
        return filter_var($object, FILTER_VALIDATE_REGEXP, $this->get_options());
    }
}
