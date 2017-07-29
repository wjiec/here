<?php
/**
 * Rsa encrypt module
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */


class Here_Widget_Rsa extends Here_Abstracts_Widget {
    /**
     * key bits length
     *
     * @var integer
     */
    private static $_key_bits;

    /**
     * openssl private key
     *
     * @var string|resource
     */
    private static $_private_key;

    /**
     * openssl public key
     *
     * @var string
     */
    private static $_public_key;

    /**
     * Here_Widget_Rsa constructor.
     * @param array $options
     * @throws Here_Exceptions_WidgetError
     */
    public function __construct(array $options = array()) {
        parent::__construct($options);
        $this->set_widget_name('RSA Encrypt');

        // check openssl is enable
        if (!self::_available()) {
            throw new Here_Exceptions_WidgetError('openssl is not available',
                'Here:Widget:Rsa:__construct');
        }
    }

    /**
     * generate private/public key pair
     */
    public function generate_new_key() {
        // @TODO
    }

    /**
     * @param string $private_key
     * @throws Here_Exceptions_InvalidPrivateKey
     */
    public function set_private_key($private_key) {
        // load private key
        $key = openssl_pkey_get_private($private_key);
        // check valid
        if (!is_resource($key)) {
            throw new Here_Exceptions_InvalidPrivateKey('private key invalid',
                'Here:Widget:Rsa:set_private_key');
        }
        // fetch private key details
        $details = openssl_pkey_get_details($key);
        // setting key bits
        self::$_key_bits = $details['bits'];
        // setting public key
        self::$_public_key = $details['key'];
        // setting private key
        self::$_private_key = $private_key;
    }

    /**
     * @param string $public_key
     * @throws Here_Exceptions_InvalidPrivateKey
     */
    public function set_public_key($public_key) {
        // load public key
        $key = openssl_pkey_get_public($public_key);
        // check valid
        if (!is_resource($key)) {
            throw new Here_Exceptions_InvalidPrivateKey('public key invalid',
                'Here:Widget:Rsa:set_public_key');
        }
        // fetch private key details
        $details = openssl_pkey_get_details($key);
        // setting key bits
        self::$_key_bits = $details['bits'];
        // setting public key
        self::$_public_key = $public_key;
    }

    /**
     * encrypt by private key
     *
     * @param string $data
     * @param string $output_type
     * @param string $glue
     * @return string
     */
    public function private_encrypt($data, $output_type = 'base64', $glue = '.') {
        return self::_encrypt('openssl_private_encrypt', self::$_private_key,
            $data, $output_type, $glue);
    }

    /**
     * decrypt by private key
     *
     * @param string $decrypted
     * @param string $source_type
     * @param string $glue
     * @return string
     */
    public function private_decrypt($decrypted, $source_type = 'base64', $glue = '.') {
        return self::_decrypt('openssl_private_decrypt', self::$_private_key,
            $decrypted, $source_type, $glue);
    }

    /**
     * encrypt by public key
     *
     * @param string $data
     * @param string $output_type
     * @param string $glue
     * @return string
     */
    public function public_encrypt($data, $output_type = 'base64', $glue = '.') {
        return self::_encrypt('openssl_public_encrypt', self::$_public_key,
            $data, $output_type, $glue);
    }

    /**
     * decrypt by public key
     *
     * @param string $decrypted
     * @param string $source_type
     * @param string $glue
     * @return string
     */
    public function public_decrypt($decrypted, $source_type = 'base64', $glue = '.') {
        return self::_decrypt('openssl_public_decrypt', self::$_public_key,
            $decrypted, $source_type, $glue);
    }

    /**
     * check openssl_* is available
     *
     * @return bool
     */
    private static function _available() {
        return function_exists('openssl_encrypt');
    }

    /**
     * @param string $data
     * @return array
     */
    private static function _segments($data) {
        switch (self::$_key_bits) {
            case 1024: $max_segment_size = 117; break;
            case 2048: $max_segment_size = 245; break;
            case 4096: $max_segment_size = 501; break;
            default: $max_segment_size = 64; break;
        }

        $segments = array();
        while (strlen($data) > $max_segment_size) {
            // getting sub string
            $segment = substr($data, 0, $max_segment_size);
            // check include multiByteString
            if (mb_strlen($segment) !== $max_segment_size) {
                // included multiByteString
                for ($len = $max_segment_size; !mb_check_encoding(substr($segment, 0, $len)); --$len) {
                    ; // empty body
                }
                $segment = substr($data, 0, $len);
            }
            $segments[] = $segment;
            $data = substr($data, strlen($segment));
        }
        $segments[] = $data;

        return $segments;
    }

    /**
     * do encrypt
     *
     * @param string $encrypt_func
     * @param string $key
     * @param string $data
     * @param string $output_type
     * @param string $glue
     * @throws Here_Exceptions_FatalError
     * @return string
     */
    private static function _encrypt($encrypt_func, $key, $data, $output_type = 'base64', $glue = '.') {
        $results = array();
        foreach (self::_segments($data) as $segment) {
            $result = &$results[];
            if (!call_user_func_array($encrypt_func, array(
                $segment, &$result, $key))) {
                //-----------------------------------------
                throw new Here_Exceptions_FatalError("encrypt error for '{$segment}'",
                    'Here:Widget:Rsa:_encrypt');
            }
        }

        if ($output_type === 'base64') {
            $results = array_map(function($segment) {
                return base64_encode($segment);
            }, $results);
        } else if ($output_type === 'hex') {
            $results = array_map(function($segment) {
                return bin2hex($segment);
            }, $results);
        }

        return join($glue, $results);
    }

    /**
     * do decrypt
     *
     * @param string $decrypt_func
     * @param string $key
     * @param string $decrypted
     * @param string $source_type
     * @param string $glue
     * @throws Here_Exceptions_FatalError
     * @return string
     */
    private static function _decrypt($decrypt_func, $key, $decrypted, $source_type = 'base64', $glue = '.') {
        // explode segment
        $segments = explode($glue, $decrypted);
        // decode to origin data
        if ($source_type === 'base64') {
            $segments = array_map(function($segment) {
                return base64_decode($segment);
            }, $segments);
        } else if ($source_type === 'hex') {
            $segments = array_map(function($segment) {
                return hex2bin($segment);
            }, $segments);
        }
        // result
        $results = array();
        foreach ($segments as $segment) {
            $result = &$results[];
            if (!call_user_func_array($decrypt_func, array(
                $segment, &$result, $key))) {
                //----------------------------------------
                throw new Here_Exceptions_FatalError('decrypt error',
                    'Here:Widget:Rsa:_decrypt');
            }
        }
        // build source
        return join('', $results);
    }
}
