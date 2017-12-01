<?php
/**
 * JwtParser.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Utils\Jwt;


/**
 * Trait JwtParser
 * @package Here\Lib\Utils\Jwt
 */
trait JwtParser {
    /**
     * @param string $jwt
     * @param string $key
     * @param bool $validate
     * @return array
     * @throws JwtGenerateSignatureError
     * @throws JwtInvalid
     */
    public static function parse(string $jwt, string $key, bool $validate = true): array {
        // explode header.payload.signature
        $segments = explode('.', $jwt);
        if (count($segments) !== 3) {
            throw new JwtInvalid('wrong number of segments');
        }
        list($encode_header, $encode_payload, $encode_signature) = $segments;

        // decode header
        $header = json_decode(self::_urlsafe_base64_decode($encode_header));
        if ($header === null) {
            throw new JwtInvalid('invalid segments of header');
        }

        // decode payload
        $payload = json_decode(self::_urlsafe_base64_decode($encode_payload), true);
        if ($payload === null) {
            throw new JwtInvalid('Invalid segment encoding of payload');
        }

        // decode signature
        $signature = self::_urlsafe_base64_decode($encode_signature);
        if ($validate) {
            if (empty($header->alg)) {
                throw new JwtInvalid('JWT header invalid, empty algorithm');
            }

            $siganture_payload = join('.', array($encode_header, $encode_payload));
            $generate_signature = JwtSignature::generate($siganture_payload, $key, new JwtAlgorithmType($header->alg));
            if ($signature !== $generate_signature) {
                throw new JwtInvalid('Signature Validation failed');
            }
        }

        return $payload;
    }

    /**
     * @param string $b64_result
     * @return string
     */
    private static function _urlsafe_base64_decode(string $b64_result): string {
        /**
         * '-' => '+',
         * '_' => '/'
         */
        $b64_result = str_replace(array('-', '_'), array('+', '/'), $b64_result);
        return base64_decode($b64_result);
    }
}
