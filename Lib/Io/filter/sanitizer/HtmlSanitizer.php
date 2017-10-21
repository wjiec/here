<?php
/**
 * HtmlSanitizer.php
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
 * Class HtmlSanitizer
 * @package Here\Lib\Io\Filter\Sanitizer
 */
class HtmlSanitizer extends IoFilterBase {
    /**
     * HtmlSanitizer constructor.
     * @param bool $quote
     */
    final public function __construct($quote = true) {
        if ($quote === false) {
            $this->add_flag(FILTER_FLAG_NO_ENCODE_QUOTES);
        }
    }

    /**
     * @param string $object
     * @param bool $default
     * @return string
     */
    final public function apply($object, $default = false) {
        return htmlspecialchars($object, ENT_QUOTES | ENT_HTML5);
    }
}
