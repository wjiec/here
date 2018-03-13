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
    final public function __construct(string $pattern) {
        // validate pattern
        if (@preg_match($pattern, null) === false) {
            throw new RegexPatternInvalid(self::$_errors[PREG_INTERNAL_ERROR]);
        }
        $this->_pattern = $pattern;
    }

    /**
     * @param string $subject
     * @param bool $offset_capture
     * @return array|bool
     */
    final public function match(string $subject, bool $offset_capture = false) {
        $flag = 0;
        if ($offset_capture === true) {
            $flag |= PREG_OFFSET_CAPTURE;
        }

        if (($count = preg_match($this->_pattern, $subject, $matches, $flag)) !== false) {
            if ($count === 0) {
                return array();
            }
            return $matches;
        }
        return false;
    }

    /**
     * @param string $subject
     * @return bool|array
     */
    final public function match_all(string $subject) {
        if (($count = preg_match_all($this->_pattern, $subject, $matches)) !== false) {
            if ($count === 0) {
                return array();
            }
            return $matches;
        }
        return false;
    }

    /**
     * @param string $subject
     * @param string $replacement
     * @param int $limit
     * @param int $count
     * @return string
     */
    final public function replace(string $subject, string $replacement, int $limit = -1, int &$count) {
        return preg_replace($this->_pattern, $replacement, $subject, $limit, $count) ?: null;
    }

    /**
     * @return string
     */
    final public function get_pattern(): string {
        return $this->_pattern;
    }

    /**
     * @return string|null
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
