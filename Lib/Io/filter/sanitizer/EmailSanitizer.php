<?php
/**
 * EmailSanitizer.php
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
 * Class EmailSanitizer
 * @package Here\Lib\Io\Filter\Sanitizer
 */
final class EmailSanitizer extends IoFilterBase {
    /**
     * @param string $object
     * @param bool $default
     * @return string
     */
    final public function apply($object, $default = false) {
        return filter_var($object, FILTER_SANITIZE_EMAIL);
    }
}
