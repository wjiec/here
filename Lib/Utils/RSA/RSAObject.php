<?php
/**
 * RsaObject.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Utils\RSA;
use Here\Config\Constant\SysConstant;
use Here\Lib\Utils\RSA\TransformAdapter\Base64Adapter;
use Here\Lib\Utils\Toolkit\StringToolkit;
use Here\Lib\Utils\Interfaces\AvailableInterface;
use Here\Lib\Utils\RSA\TransformAdapter\TransformAdapterInterface;


/**
 * Class RsaObject
 * @package Lib\Utils\Rsa
 */
final class RSAObject implements AvailableInterface {
    /**
     * @var string|null
     */
    private $_private_key;

    /**
     * @var string|null
     */
    private $_public_key;

    /**
     * @var int
     */
    private $_key_bits;

    /**
     * RSAObject constructor.
     * @param null|string $private_or_public
     * @throws RSAError
     */
    final public function __construct(?string $private_or_public = null) {
        if ($private_or_public !== null) {
            // standardize string
            $private_or_public = StringToolkit::crlf_to_lf($private_or_public);

            $is_private = true;
            $key = openssl_pkey_get_private($private_or_public);
            if (!is_resource($key)) {
                // check is public
                $key = openssl_pkey_get_public($private_or_public);
                if (!is_resource($key)) {
                    throw new RSAError('rsa key string invalid');
                }

                // switch to public
                $is_private = false;
            }

            // fetch private key details
            $details = openssl_pkey_get_details($key);
            if ($details === false) {
                throw new RSAError(StringToolkit::format('get detail of %s key error',
                    $is_private ? 'private' : 'public'));
            }

            $this->_key_bits = $details['bits'];
            $this->_public_key = $details['key'];
            $this->_private_key = $is_private ? $private_or_public : null;
        } else {
            $this->_private_key = null;
            $this->_public_key = null;
            $this->_key_bits = 0;
        }
    }

    /**
     * @return bool
     */
    final public static function available(): bool {
        return function_exists('openssl_encrypt');
    }

    /**
     * @return string
     */
    final public function get_public_key(): string {
        return $this->_public_key;
    }

    /**
     * @return int
     */
    final public function get_key_bits(): int {
        return $this->_key_bits;
    }

    /**
     * @param string $data
     * @param string $glue
     * @param TransformAdapterInterface|null $adapter
     * @return string
     * @throws RSAError
     */
    final public function encrypt(string $data, string $glue = '.',
                                         ?TransformAdapterInterface $adapter = null): string {
        // public_encrypt
        return $this->_encrypt(false, $data, $glue, $adapter ?? new Base64Adapter());
    }

    /**
     * @param string $data
     * @param string $glue
     * @param TransformAdapterInterface|null $adapter
     * @return string
     * @throws RSAError
     */
    final public function decrypt(string $data, string $glue = '.',
                                  ?TransformAdapterInterface $adapter = null): string {
        // private_decrypt
        if ($this->_private_key) {
            return $this->_decrypt(true, $data, $glue, $adapter ?? new Base64Adapter());
        }
        return SysConstant::EMPTY_STRING;
    }

    /**
     * @param string $data
     * @param string $glue
     * @param TransformAdapterInterface|null $adapter
     * @return string
     * @throws RSAError
     */
    final public function signature(string $data, string $glue = '.',
                                            ?TransformAdapterInterface $adapter = null): string {
        // private_encrypt
        if ($this->_private_key) {
            return $this->_encrypt(true, $data, $glue, $adapter ?? new Base64Adapter());
        }
        return SysConstant::EMPTY_STRING;
    }

    /**
     * @param string $data
     * @param string $glue
     * @param TransformAdapterInterface|null $adapter
     * @return string
     * @throws RSAError
     */
    final public function validate(string $data, string $glue = '.',
                                   ?TransformAdapterInterface $adapter = null): string {
        // public_decrypt
        return $this->_decrypt(false, $data, $glue, $adapter ?? new Base64Adapter());
    }

    /**
     * @param bool $is_private
     * @param string $data
     * @param string $glue
     * @param TransformAdapterInterface|null $adapter
     * @return string
     * @throws RSAError
     */
    final private function _encrypt(bool $is_private, string $data, string $glue,
                                    ?TransformAdapterInterface $adapter): string {
        $results = array();
        foreach (self::_split_data($data, $this->_key_bits) as $segment) {
            if ($is_private) {
                $encrypt_result = openssl_private_encrypt($segment, $result, $this->_private_key);
            } else {
                $encrypt_result = openssl_public_encrypt($segment, $result, $this->_public_key);
            }

            if ($encrypt_result === false) {
                throw new RSAError(openssl_error_string());
            }

            $results[] = $result;
        }

        return $adapter->transform_forward($results, $glue);
    }

    /**
     * @param bool $is_private
     * @param string $data
     * @param string $glue
     * @param TransformAdapterInterface|null $adapter
     * @return string
     * @throws RSAError
     */
    final private function _decrypt(bool $is_private, string $data, string $glue,
                                    ?TransformAdapterInterface $adapter): string {
        $segments = $adapter->transform_backward($data, $glue);

        $results = array();
        foreach ($segments as $segment) {
            if ($is_private) {
                $decrypt_result = openssl_private_decrypt($segment, $result, $this->_private_key);
            } else {
                $decrypt_result = openssl_public_decrypt($segment, $result, $this->_public_key);
            }

            if ($decrypt_result === false) {
                throw new RSAError(openssl_error_string());
            }

            $results[] = $result;
        }

        return join('', $results);
    }

    /**
     * @param string $data
     * @param int $key_bits
     * @return array
     */
    final private static function _split_data(string $data, int $key_bits): array {
        switch ($key_bits) {
            case 1024: $max_segment_size = 117; break;
            case 2048: $max_segment_size = 245; break;
            case 4096: $max_segment_size = 501; break;
            default: $max_segment_size = 64; break;
        }

        $segments = array();
        while (strlen($data) > $max_segment_size) {
            $segment = substr($data, 0, $max_segment_size);

            // multiByteString check
            if (mb_strlen($segment) !== $max_segment_size) {
                $mb_max_segment_size = $max_segment_size;
                while (!mb_check_encoding(substr($segment, 0, $mb_max_segment_size))) {
                    --$mb_max_segment_size;
                }
                $segment = substr($data, 0, $mb_max_segment_size);
            }

            $segments[] = $segment;
            $data = substr($data, strlen($segment));
        }

        $segments[] = $data;
        return $segments;
    }
}
