<?php
/**
 * NumberSanitizer.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Io\Filter\Sanitizer;
use Here\Lib\Io\Filter\IoFilterBase;


/**
 * Class NumberSanitizer
 * @package Here\Lib\Io\Filter\Sanitizer
 */
final class NumberSanitizer extends IoFilterBase {
    /**
     * NumberSanitizer constructor.
     * @param bool $allow_float
     * @param bool $fraction
     * @param bool $thousand
     * @param bool $scientific
     */
    final public function __construct($allow_float = true, $fraction = true, $thousand = false, $scientific = true) {
        if ($allow_float === true) {
             $this->_filter_id = FILTER_SANITIZE_NUMBER_FLOAT;

            if ($fraction) {
                // FILTER_FLAG_ALLOW_FRACTION - Allow fraction separator (like . )
                $this->add_flag(FILTER_FLAG_ALLOW_FRACTION);
            }

            if ($thousand) {
                // FILTER_FLAG_ALLOW_THOUSAND - Allow thousand separator (like , )
                $this->add_flag(FILTER_FLAG_ALLOW_THOUSAND);
            }

            if ($scientific) {
                // FILTER_FLAG_ALLOW_SCIENTIFIC - Allow scientific notation (like e and E)
                $this->add_flag(FILTER_FLAG_ALLOW_SCIENTIFIC);
            }
        } else {
             $this->_filter_id = FILTER_SANITIZE_NUMBER_INT;
        }
    }

    /**
     * @param string $object
     * @param bool $default
     * @return string
     */
    final public function apply($object, $default = false) {
        return filter_var($object, $this->_filter_id, $this->get_options());
    }
}
