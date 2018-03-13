<?php
/**
 * StringSanitizer.php
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
 * Class StringSanitizer
 * @package Here\Lib\Io\Filter\Sanitizer
 */
class StringSanitizer extends IoFilterBase {
    final public function __construct($quote = true, $hold_low = true, $hold_high = true, $encode_amp = true) {
        if ($quote === false) {
            // Do not encode quotes
            $this->add_flag(FILTER_FLAG_NO_ENCODE_QUOTES);
        }

        // FILTER_FLAG_ENCODE_LOW - Encode characters with ASCII value < 32
        // FILTER_FLAG_STRIP_LOW - Remove characters with ASCII value < 32
        $this->add_flag($hold_low ? FILTER_FLAG_ENCODE_LOW : FILTER_FLAG_STRIP_LOW);

        // FILTER_FLAG_ENCODE_HIGH - Encode characters with ASCII value > 127
        // FILTER_FLAG_STRIP_HIGH - Remove characters with ASCII value > 127
        $this->add_flag($hold_high ? FILTER_FLAG_ENCODE_HIGH : FILTER_FLAG_STRIP_HIGH);

        if ($encode_amp === true) {
            // encode the "&" character to &amp;
            $this->add_flag(FILTER_FLAG_ENCODE_AMP);
        }
    }

    /**
     * @param string $object
     * @param bool $default
     * @return string
     */
    final public function apply($object, $default = false) {
        return filter_var($object, FILTER_SANITIZE_STRING, $this->get_options());
    }
}
