<?php
/**
 * Here Widget: Json Web Token Generator/Validator
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */


/**
 * Widget: Json Web Token
 */
class Here_Widget_Jwt extends Here_Abstracts_Widget {
    /**
     * Here_Widget_Jwt constructor.
     *
     * @param array $options
     */
    public function __construct(array $options = array()) {
        parent::__construct($options);
        $this->set_widget_name('Jwt Generator/Validator');
    }

    /**
     * Json Web Token generator
     *
     * @param array $payload
     * @param string $key
     * @param string $alg
     * @return string
     */
    public function generate_token(array $payload, $key, $alg = 'HS256') {
        // convert to upper case
        $alg = strtoupper($alg);
        // build JWT header
        $header = array(
            'typ' => 'JWT',
            'alg' => $alg
        );
        // encode header and payload
        $encode_header = self::urlsafe_base64_encode(json_encode($header));
        $encode_payload = self::urlsafe_base64_encode(json_encode($payload));
        // signature input
        $signature_source = join('.', array($encode_header, $encode_payload));
        // calc signature
        $signature = self::calc_signature($signature_source, $key, $alg);
        // encode signature
        $encode_signature = self::urlsafe_base64_encode($signature);
        return join('.', array($encode_header, $encode_payload, $encode_signature));
    }

    /**
     * Json Web Token decode
     *
     * @param string $jwt
     * @param string $key
     * @param bool $verify
     * @return array
     * @throws Here_Exceptions_WidgetError
     */
    public function token_decode($jwt, $key, $verify = true) {
        // explode header.payload.signature
        $segments = explode('.', $jwt);
        // check segments count
        if (count($segments) !== 3) {
            throw new Here_Exceptions_WidgetError("Wrong number of segments",
                'Here:Widget:Jwt:token_decode');
        }
        // all segments
        list($encode_header, $encode_payload, $encode_signature) = $segments;
        // decode header
        $header = json_decode(self::urlsafe_base64_decode($encode_header));
        if ($header === null) {
            // decode error
            throw new Here_Exceptions_WidgetError("Invalid segment encoding of header",
                'Here:Widget:Jwt:token_decode');
        }
        // decode payload
        $payload = json_decode(self::urlsafe_base64_decode($encode_payload), true);
        if ($payload === null) {
            // decode error
            throw new Here_Exceptions_WidgetError("Invalid segment encoding of payload",
                'Here:Widget:Jwt:token_decode');
        }
        // decode signature
        $signature = self::urlsafe_base64_decode($encode_signature);
        // verify signature
        if ($verify === true) {
            if (empty($header->alg)) {
                throw new Here_Exceptions_WidgetError("JWT header invalid, empty algorithm",
                    'Here:Widget:Jwt:token_decode');
            }
            // validate signature is correct
            if (!self::_validate_signature(
                // calc signature source
                join('.', array($encode_header, $encode_payload)), $key, $header->alg,
                // verify signature
                $signature)) {
                //-----------------------------------
                throw new Here_Exceptions_WidgetError("Signature Validation failed",
                    'Here:Widget:Jwt:token_decode');
            }
        }
        // validate correct, payload is safe
        return $payload;
    }

    /**
     * urlsafe base64 encode
     *
     * @param string $payload
     * @return mixed|string
     */
    public static function urlsafe_base64_encode($payload) {
        $b64_result = base64_encode($payload);
        /**
         * '+'  => '-',
         * '/'  => '_',
         * '\r' => '',
         * '\n' => '',
         * '='  => ''
         */
        $b64_result = str_replace(array('+', '/', '\r', '\n', '='), array('-', '_'), $b64_result);
        return $b64_result;
    }

    /**
     * urlsafe base64 decode
     *
     * @param string $b64_result
     * @return bool|string
     */
    public static function urlsafe_base64_decode($b64_result) {
        /**
         * '-' => '+',
         * '_' => '/'
         */
        $b64_result = str_replace(array('-', '_'), array('+', '/'), $b64_result);
        return base64_decode($b64_result);
    }

    /**
     * @param string $source
     * @param string $key
     * @param string $alg
     * @return string
     * @throws Here_Exceptions_WidgetError
     */
    public static function calc_signature($source, $key, $alg) {
        switch ($alg) {
            case 'HS256':
                return hash_hmac('sha256', $source, $key, true);
            case 'HS384':
                return hash_hmac('sha384', $source, $key, true);
            case 'HS512':
                return hash_hmac('sha512', $source, $key, true);
            case 'RS256':
                return self::_generate_rsa_signature($source, $key, OPENSSL_ALGO_SHA256);
            case 'RS384':
                return self::_generate_rsa_signature($source, $key, OPENSSL_ALGO_SHA384);
            case 'RS512':
                return self::_generate_rsa_signature($source, $key, OPENSSL_ALGO_SHA512);
            default:
                throw new Here_Exceptions_WidgetError("Unsupported or invalid signing algorithm",
                    'Here:Widget:Jwt:calc_signature');
        }
    }

    /**
     * @param string $source
     * @param string $key
     * @param int $alg
     * @return string
     * @throws Here_Exceptions_WidgetError
     */
    private static function _generate_rsa_signature($source, $key, $alg) {
        /**
         * computes a signature for the specified data by generating a cryptographic digital
         * signature using the private key associated with priv_key_id.
         */
        if (!openssl_sign($source, $signature, $key, $alg)) {
            throw new Here_Exceptions_WidgetError("generate rsa signature error",
                'Here:Widget:Jwt:_generate_rsa_signature');
        }
        return $signature;
    }

    /**
     * @param string $source
     * @param string $key
     * @param string $alg
     * @param string $signature
     * @return bool
     * @throws Here_Exceptions_WidgetError
     */
    private static function _validate_signature($source, $key, $alg, $signature) {
        switch ($alg) {
            case 'HS256':
            case 'HS384':
            case 'HS512':
                return self::calc_signature($source, $key, $alg) === $signature;
            case 'RS256':
                return boolval(openssl_verify($source, $signature, $key, OPENSSL_ALGO_SHA256));
            case 'RS384':
                return boolval(openssl_verify($source, $signature, $key, OPENSSL_ALGO_SHA384));
            case 'RS512':
                return boolval(openssl_verify($source, $signature, $key, OPENSSL_ALGO_SHA512));
            default:
                throw new Here_Exceptions_WidgetError("Unsupported or invalid signing algorithm",
                    'Here:Widget:Jwt:_validate_signature');
        }
    }
}
