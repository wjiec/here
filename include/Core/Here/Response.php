<?php

/**
 * @author ShadowMan
 * @package Here.Response
 */
class Response {
    public static function header($header, $value) {
        if (is_string($header) && is_string($value)) {
            header("{$header}: {$value}");
        }
    }
}

?>