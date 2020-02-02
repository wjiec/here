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

if (!function_exists('aes_encrypt')) {
    /**
     * Encrypt by aes-256-cbc with iv and base64_encode automatically
     *
     * @param string $data
     * @param string $key
     * @param string $iv
     * @return false|string
     */
    function aes_encrypt(string $data, string $key, string $iv) {
        return base64_encode_safe(openssl_encrypt($data, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv));
    }
}

if (!function_exists('aes_decrypt')) {
    /**
     * Decrypt by aes-256-cbc with iv and base64_decode automatically
     *
     * @param string $data
     * @param string $key
     * @param string $iv
     * @return false|string
     */
    function aes_decrypt(string $data, string $key, string $iv) {
        return openssl_decrypt(base64_decode_safe($data), 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
    }
}

if (!function_exists('array_at')) {
    /**
     * Gets the value from parameter object and default when key not found in object
     *
     * @param array $object
     * @param string|array $paths
     * @param null $default
     * @param string $delimiter
     * @return array|mixed|null
     */
    function array_at(array $object, $paths, $default = null, string $delimiter = '.') {
        if (!is_array($paths)) {
            $paths = explode($delimiter, strval($paths));
        }

        foreach ($paths as $index) {
            if (!isset($object[$index])) {
                return $default;
            }
            $object = $object[$index];
        }

        return $object;
    }
}
