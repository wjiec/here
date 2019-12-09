<?php
/**
 * here application
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.org>
 * @copyright Copyright (C) 2016-2019 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/lsalio/here
 */
namespace Here\Library\Utils;


/**
 * Class Text
 * @package Here\Library\Utils
 */
class Text {

    /**
     * Replaces the crlf into lf
     *
     * @param string $text
     * @return string
     */
    public static function normalize(string $text): string {
        return str_replace(["\r\n", "\r"], "\n", $text);
    }

    /**
     * Split text with EOF
     *
     * @param string $text
     * @param string $eof
     * @return array
     */
    public static function lines(string $text, string $eof = "\n"): array {
        return explode($eof, $text);
    }

    /**
     * Concat strings by EOF
     *
     * @param array $lines
     * @param string $eof
     * @return string
     */
    public static function concat(array $lines, string $eof = "\n"): string {
        return join($eof, $lines);
    }

    /**
     * Returns true when text has needle prefix, false otherwise
     *
     * @param string $text
     * @param string $needle
     * @return bool
     */
    public static function hasPrefix(string $text, string $needle): bool {
        return mb_strpos($text, $needle) === 0;
    }

    /**
     * Returns true when text has needle suffix, false otherwise
     *
     * @param string $text
     * @param string $needle
     * @return bool
     */
    public static function hasSuffix(string $text, string $needle): bool {
        return mb_strpos($text, $needle) === mb_strlen($text) - mb_strlen($needle);
    }

}
