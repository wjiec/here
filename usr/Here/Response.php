<?php
/**
 * Here Response Class
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */


class Here_Response {
    /**
     * return plain text response
     *
     * @param string $text
     */
    public static function plain_response($text) {
        if (!is_string($text)) {
            if (method_exists($text, '__toString')) {
                $text = $text->__toString();
            } else {
                $text = strval($text);
            }
        }

        self::response_end($text);
    }

    /**
     * json response return
     *
     * @param array $response
     * @throws Here_Exceptions_ResponseError
     */
    public static function json_response(array $response) {
        try {
            $text = self::_json_encode_safe($response);
            Here_Request::set_mime('json');
            self::response_end($text);
        } catch (Exception $e) {
            throw new Here_Exceptions_ResponseError($e->getMessage(),
                'Here:Response:json_response');
        }
    }

    /**
     * wrapper function of iconv_safe, convert string to default encoding
     *
     * @param string $string
     * @param string $source_encoding
     * @return string
     */
    public static function _Text($string, $source_encoding = 'GB2312') {
        return self::_iconv_safe($string, $source_encoding);
    }

    /**
     * output response and exit script
     *
     * @param $text_response
     */
    private static function response_end($text_response) {
        echo $text_response;
        exit;
    }

    /**
     * json encode by safe
     *
     * @param array $array
     * @return string
     */
    private static function _json_encode_safe(array $array) {
        // using builtin json_encode
        $text = json_encode($array);
        // check encode result is null or false
        if ($text === null || $text === false) {
            // fix encoding error
            return self::_json_encode_safe(self::_array_encoding_fix($array));
        }
        return $text;
    }

    /**
     * fix array encoding error
     *
     * @param array $array
     * @return array
     */
    private static function _array_encoding_fix(array $array) {
        // foreach all element
        foreach ($array as $key => &$val) {
            if (is_array($val)) {
                $val = self::_array_encoding_fix($val);
            } else if (is_string($val)) {
                $val = self::_iconv_safe($val);
            }
        }
        // result
        return $array;
    }

    /**
     * check string if invalid, than using iconv
     *
     * @param string $string
     * @param string $source_encoding
     * @throws Here_Exceptions_FatalError
     * @return string
     */
    private static function _iconv_safe($string, $source_encoding = 'GB2312') {
        if (json_encode($string) === false) {
            try {
                return trim(iconv($source_encoding, _here_default_charset_, $string));
            } catch (Exception $e) {
                throw new Here_Exceptions_FatalError("convert encoding error occurs",
                    'Here:Response:iconv_safe');
            }
        }
        // result
        return $string;
    }
}