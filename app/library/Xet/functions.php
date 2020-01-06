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
namespace Here\Library\Xet;


if (!function_exists('current_date')) {
    /**
     * Gets the date string current
     *
     * @return string
     */
    function current_date() {
        return date('Y-m-d H:i:s');
    }
}

if (!function_exists('base64_encode_safe')) {
    /**
     * Encode string by base64 with url safe
     *
     * @param string $data
     * @return mixed
     */
    function base64_encode_safe(string $data) {
        var_dump(base64_encode($data));
        return str_replace(['+', '/'], ['-', '_'], trim(base64_encode($data), '='));
    }
}

if (!function_exists('base64_decode_safe')) {
    /**
     * Decode string by base64 with url safe
     *
     * @param string $data
     * @return mixed
     */
    function base64_decode_safe(string $data) {
        return base64_decode(str_replace(['-', '_'], ['+', '/'], $data) .
            substr('====', strlen($data) % 4));
    }
}
