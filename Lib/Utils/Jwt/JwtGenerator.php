<?php
/**
 * JwtGenerator.php
 *
 * @package   here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Utils\Jwt;


/**
 * Trait JwtGenerator
 * @package Here\Lib\Utils\Jwt
 */
trait JwtGenerator {
    /**
     * @param array $payload
     * @param string $key
     * @param JwtAlgorithmType $alg
     * @return string
     * @throws JwtGenerateSignatureError
     */
    public static function generate(array $payload, string $key, JwtAlgorithmType $alg): string {
        // build JWT header
        $header = array(
            'typ' => 'JWT',
            'alg' => $alg->value()
        );
        // encode header
        $encode_header = self::_urlsafe_base64_encode(json_encode($header));
        // encode payload
        $encode_payload = self::_urlsafe_base64_encode(json_encode($payload));
        // signature input
        $signature_source = join('.', array($encode_header, $encode_payload));
        // calc signature
        $signature = JwtSignature::generate($signature_source, $key, $alg);
        // encode signature
        $encode_signature = self::_urlsafe_base64_encode($signature);
        // header, payload, signature assembled together using '.'
        return join('.', array($encode_header, $encode_payload, $encode_signature));
    }

    /**
     * @param string $payload
     * @return string
     */
    private static function _urlsafe_base64_encode(string $payload): string {
        $b64_result = base64_encode($payload);
        /**
         * '+'  => '-',
         * '/'  => '_',
         * '\r' => '',
         * '\n' => '',
         * '='  => ''
         */
        return str_replace(array('+', '/', '\r', '\n', '='), array('-', '_'), $b64_result);
    }
}
