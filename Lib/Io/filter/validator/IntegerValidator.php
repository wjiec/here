<?php
/**
 * IntegerValidator.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Io\Filter\Validator;
use Here\Lib\Assert;
use Here\Lib\Io\Filter\IoFilterBase;


/**
 * Class IntegerValidator
 * @package Here\Lib\Io\Filter\Validator
 */
final class IntegerValidator extends IoFilterBase {
    /**
     * IntegerValidator constructor.
     */
    final public function __construct(
        $min = self::INTEGER_VALIDATOR_RANGE_MINUS_INF,
        $max = self::INTEGER_VALIDATOR_RANGE_PLUS_INF,
        $allow_oct = true,
        $allow_hex = true
    ) {
        if ($min !== self::INTEGER_VALIDATOR_RANGE_MINUS_INF) {
            Assert::Integer($min);
            $this->min_range = $min;
        }

        if ($max !== self::INTEGER_VALIDATOR_RANGE_PLUS_INF) {
            Assert::Integer($max);
            $this->max_range = $max;
        }

        if ($allow_oct === true) {
            $this->add_flag(FILTER_FLAG_ALLOW_OCTAL);
        }

        if ($allow_hex === true) {
            $this->add_flag(FILTER_FLAG_ALLOW_HEX);
        }
    }

    /**
     * @see IoFilterBase::apply()
     * @param string $object
     * @param bool|mixed $default
     * @return mixed
     */
    final public function apply($object, $default = false) {
        $this->default = $default;
        return filter_var($object, FILTER_VALIDATE_INT, $this->get_options());
    }

    // plus infinity
    const INTEGER_VALIDATOR_RANGE_PLUS_INF  = 'PLUS_INF';

    // minus infinity
    const INTEGER_VALIDATOR_RANGE_MINUS_INF = 'MINUS_INF';
}
