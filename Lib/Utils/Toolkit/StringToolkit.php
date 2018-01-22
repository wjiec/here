<?php
/**
 * StringToolkit.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Utils\Toolkit;
use Here\Config\Constant\DefaultConstant;
use Here\Config\Constant\SysConstant;


/**
 * Class StringToolkit
 * @package Here\Lib\Utils\Toolkit
 */
final class StringToolkit {
    /**
     * @param int $length
     * @return string
     */
    final public static function random_string(int $length): string {
        if ($length <= strlen(SysConstant::RANDOM_CHARACTERS)) {
            return substr(str_shuffle(SysConstant::RANDOM_CHARACTERS), 0, $length);
        } else {
            $result_string = '';

            // build random string
            while (strlen($result_string) < $length) {
                $result_string .= str_shuffle(SysConstant::RANDOM_CHARACTERS);
            }

            return substr($result_string, 0, $length);
        }
    }

    /**
     * @param string $string
     * @param string $source_encoding
     * @return string
     */
    final public static function smart_iconv(string $string, string $source_encoding = 'gb2312'): string {
        if (json_encode($string) === false) {
            return trim(iconv($source_encoding, DefaultConstant::DEFAULT_CHARSET, $string));
        }
        return $string;
    }

    /**
     * @param string $string
     * @return string
     */
    final public static function crlf_to_lf(string $string): string {
        return str_replace("\r\n", "\n", $string);
    }

    /**
     * @param string $format
     * @param array ...$args
     * @return string
     */
    final public static function format(string $format, ...$args): string {
        return sprintf($format, ...$args);
    }

    /**
     * @param string $string
     * @param string $source_encoding
     * @return string
     */
    final public static function TEXT(string $string, string $source_encoding = 'gb2312'): string {
        return self::smart_iconv($string, $source_encoding);
    }
}
