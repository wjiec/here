<?php
/**
 * ResponseHeader.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Stream\OStream\Client;
use Here\Lib\Http\HttpStatusCode;


/**
 * Trait ResponseHeader
 * @package Here\Lib\Stream\OStream\Client
 */
trait ResponseHeader {
    /**
     * @var array
     */
    private static $_http_headers;

    /**
     * @var HttpStatusCode
     */
    private static $_http_status_code;

    /**
     * @param string $name
     * @param string $val
     * @param bool $override
     */
    final public function response_header(string $name, string $val, bool $override = false): void {
        if (!$override && isset(self::$_http_headers[$name])) {
            throw new ResponseHeaderOverrideError("cannot override '{$name}' header");
        }

        self::$_http_headers[$name] = $val;
    }

    /**
     * @param int $code
     */
    final public function response_status_code(HttpStatusCode $code): void {
        self::$_http_status_code = $code;
    }
}
