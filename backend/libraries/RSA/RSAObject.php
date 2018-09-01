<?php
/**
 * RsaObject.php
 *
 * provide some rsa support
 *
 * @package   here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Libraries\RSA;


use Here\Libraries\RSA\Transform\Base64Transform;
use Here\Libraries\RSA\Transform\TransformInterface;


/**
 * Class RSAObject
 * @package Here\Libraries\RSA
 */
final class RSAObject {

    /**
     * @var string|null
     */
    private $private_key;
    /**
     * @var string|null
     */
    private $public_key;
    /**
     * @var int
     */
    private $key_bits;

    /**
     * RSAObject constructor.
     * @param string $private_or_public
     * @throws RSAError
     */
    final public function __construct(string $private_or_public) {
        $private_or_public = str_replace("\r\n", "\n", $private_or_public);

        $is_private = true;
        $key = openssl_pkey_get_private($private_or_public);
        if (!is_resource($key)) {
            $key = openssl_pkey_get_public($private_or_public);
            if (!is_resource($key)) {
                throw new RSAError('rsa key string invalid');
            }

            $is_private = false;
        }

        $details = openssl_pkey_get_details($key);
        if ($details === false) {
            throw new RSAError(sprintf("Get detail of %s key error",
                $is_private ? 'private' : 'public'));
        }

        $this->key_bits = $details['bits'];
        $this->public_key = $details['key'];
        $this->private_key = $is_private ? $private_or_public : null;
    }

    /**
     * @param int $key_bits
     * @param string $digest_alg
     * @return RSAObject
     * @throws RSAError
     */
    final public static function generate(int $key_bits = 1024, $digest_alg = 'sha512'): self {
        $rsa_config = array(
            'digest_alg' => $digest_alg,
            'private_key_bits' => $key_bits,
            'private_key_type' => OPENSSL_KEYTYPE_RSA
        );

        $key = openssl_pkey_new($rsa_config);
        if ($key === false) {
            throw new RSAError(openssl_error_string());
        }

        openssl_pkey_export($key, $private_key);
        return new static(trim($private_key));
    }

    /**
     * @return string
     */
    final public function getPrivateKey(): string {
        return $this->private_key;
    }

    /**
     * @return string
     */
    final public function getPublicKey(): string {
        return $this->public_key;
    }

    /**
     * @return int
     */
    final public function getKeyBits(): int {
        return $this->key_bits;
    }

    /**
     * encrypt by public key
     *
     * @param string $data
     * @param string $glue
     * @param TransformInterface|null $adapter
     * @return string
     * @throws RSAError
     */
    final public function encrypt(string $data, string $glue = '.', ?TransformInterface $adapter = null): string {
        return $this->doEncrypt(self::USE_PUBLIC, $data, $glue, $adapter ?? new Base64Transform());
    }

    /**
     * decrypt by private key
     *
     * @param string $data
     * @param string $glue
     * @param TransformInterface|null $adapter
     * @return string|null
     * @throws RSAError
     */
    final public function decrypt(string $data, string $glue = '.', ?TransformInterface $adapter = null): ?string {
        if ($this->private_key) {
            return $this->doDecrypt(self::USE_PRIVATE, $data, $glue, $adapter ?? new Base64Transform());
        }
        return null;
    }

    /**
     * encrypt by private key
     *
     * @param string $data
     * @param string $glue
     * @param TransformInterface|null $adapter
     * @return string
     * @throws RSAError
     */
    final public function signature(string $data, string $glue = '.', ?TransformInterface $adapter = null): ?string {
        if ($this->private_key) {
            return $this->doEncrypt(self::USE_PRIVATE, $data, $glue, $adapter ?? new Base64Transform());
        }
        return null;
    }

    /**
     * decrypt by public
     *
     * @param string $data
     * @param string $glue
     * @param TransformInterface|null $adapter
     * @return string
     * @throws RSAError
     */
    final public function validate(string $data, string $glue = '.', ?TransformInterface $adapter = null): string {
        return $this->doDecrypt(self::USE_PUBLIC, $data, $glue, $adapter ?? new Base64Transform());
    }

    /**
     * @param bool $is_private
     * @param string $data
     * @param string $glue
     * @param TransformInterface|null $adapter
     * @return string
     * @throws RSAError
     */
    final private function doEncrypt(bool $is_private, string $data, string $glue,
                                     ?TransformInterface $adapter): string {
        $results = array();
        foreach (self::splitSource($data, $this->key_bits) as $segment) {
            $encrypt_status = openssl_private_encrypt($segment, $result,
                $is_private ? $this->private_key : $this->public_key);

            if (!$encrypt_status) {
                throw new RSAError(openssl_error_string());
            }

            $results[] = $result;
        }

        return $adapter->forward($results, $glue);
    }

    /**
     * @param bool $is_private
     * @param string $data
     * @param string $glue
     * @param TransformInterface|null $adapter
     * @return string
     * @throws RSAError
     */
    final private function doDecrypt(bool $is_private, string $data, string $glue,
                                     ?TransformInterface $adapter): string {
        $segments = $adapter->backward($data, $glue);
        $results = array();

        foreach ($segments as $segment) {
            $decrypt_status = openssl_public_decrypt($segment, $result,
                $is_private ? $this->private_key : $this->public_key);

            if (!$decrypt_status) {
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
    final private static function splitSource(string $data, int $key_bits): array {
        switch ($key_bits) {
            case 1024: $max_segment_size = 117; break;
            case 2048: $max_segment_size = 245; break;
            case 4096: $max_segment_size = 501; break;
            default: $max_segment_size = 64; break;
        }

        $segments = array();
        while (strlen($data) > $max_segment_size) {
            $segment = substr($data, 0, $max_segment_size);

            //  check string with multi-bytes
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

    private const USE_PRIVATE = true;

    private const USE_PUBLIC = false;

}
