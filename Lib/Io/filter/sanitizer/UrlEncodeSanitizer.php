<?php
/**
 * UrlEncodeSanitizer.php
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
 * Class UrlEncodeSanitizer
 * @package Here\Lib\io\filter\sanitizer
 */
final class UrlEncodeSanitizer extends IoFilterBase {
    /**
     * UrlEncodeSanitizer constructor.
     * @param bool $hold_low
     * @param bool $hold_high
     */
    final public function __construct($hold_low = true, $hold_high = true) {
        // FILTER_FLAG_ENCODE_LOW - Encode characters with ASCII value < 32
        // FILTER_FLAG_STRIP_LOW - Remove characters with ASCII value < 32
        $this->add_flag($hold_low ? FILTER_FLAG_ENCODE_LOW : FILTER_FLAG_STRIP_LOW);

        // FILTER_FLAG_ENCODE_HIGH - Encode characters with ASCII value > 127
        // FILTER_FLAG_STRIP_HIGH - Remove characters with ASCII value > 127
        $this->add_flag($hold_high ? FILTER_FLAG_ENCODE_HIGH : FILTER_FLAG_STRIP_HIGH);
    }

    /**
     * @param string $object
     * @param bool $default
     * @return string
     */
    final public function apply($object, $default = false) {
        return filter_var($object, FILTER_SANITIZE_ENCODED, $this->get_options());
    }
}
