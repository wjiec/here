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
     */
    public static function json_response(array $response) {
        try {
            $text = json_encode($response);
            Here_Request::set_mime('json');
            self::response_end($text);
        } catch (Exception $e) {
            throw new Here_Exceptions_ResponseError($e->getMessage(),
                'Here:Response:json_response');
        }
    }

    private static function response_end($text_response) {
        echo $text_response;
        exit;
    }
}