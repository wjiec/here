<?php
/**
 * Regex.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Ext\Regex;
use Here\Lib\Assert;


/**
 * Class Regex
 * @package Here\Lib\Ext
 */
final class Regex {
    /**
     * @var string
     */
    private $_pattern;

    /**
     * Regex constructor.
     * @param string $pattern
     * @throws RegexPatternInvalid
     */
    final public function __construct($pattern) {
        Assert::String($pattern);

        // validate pattern
        if (@preg_match($pattern, null) === false) {
            throw new RegexPatternInvalid(self::$_errors[PREG_INTERNAL_ERROR]);
        }
        $this->_pattern = $pattern;
    }

    /**
     * @param string $object
     * @param bool $offset_capture
     * @return bool|array
     */
    final public function match($object, $offset_capture = false) {
        $flag = 0;
        if ($offset_capture === true) {
            $flag |= PREG_OFFSET_CAPTURE;
        }

        if (($count = preg_match($this->_pattern, $object, $matches, $flag)) !== false) {
            if ($count === 0) {
                return array();
            }
            return $matches;
        }
        return false;
    }

    /**
     * @param string $object
     * @return bool|array
     */
    final public function match_all($object) {
        if (($count = preg_match_all($this->_pattern, $object, $matches)) !== false) {
            if ($count === 0) {
                return array();
            }
            return $matches;
        }
        return false;
    }

    /**
     * @param string $object
     * @param string $replacement
     * @param int $limit
     * @param int $count
     * @return string
     */
    final public function replace($object, $replacement, $limit = -1, &$count) {
        return preg_replace($this->_pattern, $replacement, $object, $limit, $count) ?: null;
    }

    /**
     * @return string
     */
    final public function get_pattern() {
        return $this->_pattern;
    }

    /**
     * @return string
     */
    final public function get_last_error() {
        if (array_key_exists(preg_last_error(), self::$_errors)) {
            return self::$_errors[preg_last_error()];
        }
        return preg_last_error() ?: null;
    }

    /**
     * @var array
     */
    private static $_errors = array(
        PREG_NO_ERROR               => 'No errors',
        PREG_INTERNAL_ERROR         => 'There was an internal PCRE error',
        PREG_BACKTRACK_LIMIT_ERROR  => 'Backtrack limit was exhausted',
        PREG_RECURSION_LIMIT_ERROR  => 'Recursion limit was exhausted',
        PREG_BAD_UTF8_ERROR         => 'The offset did not correspond to the begin of a valid UTF-8 code point',
        PREG_BAD_UTF8_OFFSET_ERROR  => 'Malformed UTF-8 data'
    );
}
