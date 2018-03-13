<?php
/**
 * JwtSignature.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Utils\Jwt;


/**
 * Class JwtSignature
 * @package Here\Lib\Utils\Jwt
 */
final class JwtSignature {
    /**
     * @param string $payload
     * @param string $key
     * @param JwtAlgorithmType $alg
     * @return string
     * @throws JwtGenerateSignatureError
     */
    public static function generate(string $payload, string $key, JwtAlgorithmType $alg): string {
        switch ($alg->value()) {
            case JwtAlgorithmType::JWT_TYPE_HS256:
                return hash_hmac('sha256', $payload, $key, true);
            case JwtAlgorithmType::JWT_TYPE_HS384:
                return hash_hmac('sha384', $payload, $key, true);
            case JwtAlgorithmType::JWT_TYPE_HS512:
                return hash_hmac('sha512', $payload, $key, true);
            case 'RS256':
                return self::_generate_rsa_signature($payload, $key, OPENSSL_ALGO_SHA256);
            case 'RS384':
                return self::_generate_rsa_signature($payload, $key, OPENSSL_ALGO_SHA384);
            case 'RS512':
                return self::_generate_rsa_signature($payload, $key, OPENSSL_ALGO_SHA512);
        }
        throw new JwtGenerateSignatureError("impossible error for jwt signature generator");
    }

    /**
     * @param string $source
     * @param string $key
     * @param int $alg
     * @return string
     * @throws JwtGenerateSignatureError
     */
    private static function _generate_rsa_signature(string $source, string $key, int $alg): string {
        if (!openssl_sign($source, $signature, $key, $alg)) {
            throw new JwtGenerateSignatureError("generate rsa signature error");
        }
        return $signature;
    }
}
