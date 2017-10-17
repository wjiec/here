<?php
/**
 * UrlSanitizer.php
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
 * Class UrlSanitizer
 * @package Here\Lib\Io\Filter\Sanitizer
 */
class UrlSanitizer extends IoFilterBase {
    /**
     * @param string $object
     * @param bool $default
     * @return mixed
     */
    final public function apply($object, $default = false) {
        return filter_var($object, FILTER_SANITIZE_URL);
    }
}
