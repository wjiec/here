<?php
/**
 * StringFilter.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Io\Filter;


/**
 * Class StringFilter
 * @package Here\Lib\IO\Filter
 */
final class StringFilter extends IoFilterBase {
    /**
     * @param string $validator
     * @param int $flags
     * @return $this
     */
    public function validate($validator, $flags) {
        return $this;
    }

    /**
     * @param string $sanitizer
     * @param int $flags
     * @return $this
     */
    public function sanitize($sanitizer, $flags) {
        return $this;
    }

    /**
     * @param callable $callback
     * @return $this;
     */
    public function callback($callback) {
        return $this;
    }
}
