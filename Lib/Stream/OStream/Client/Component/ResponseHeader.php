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
namespace Here\Lib\Stream\OStream\Client\Component;


/**
 * Trait ResponseHeader
 * @package Here\Lib\Stream\OStream\Client
 */
trait ResponseHeader {
    /**
     * @var array
     */
    private static $_global_http_headers;

    /**
     * @var array
     */
    private $_http_headers;

    /**
     * @param string $name
     * @param string $val
     * @param bool $override
     * @throws ResponseHeaderOverrideError
     */
    final public function response_header(string $name, string $val, bool $override = false): void {
        if (!$override && isset($this->_http_headers[$name])) {
            throw new ResponseHeaderOverrideError("cannot override '{$name}' header");
        }

        $this->_http_headers[$name] = $val;
    }

    /**
     * @param string $name
     * @param string $val
     * @param bool $override
     * @throws ResponseHeaderOverrideError
     */
    final public static function global_response_header(string $name, string $val, bool $override = false): void {
        if (!$override && isset(self::$_global_http_headers[$name])) {
            throw new ResponseHeaderOverrideError("cannot override '{$name}' header");
        }

        self::$_global_http_headers[$name] = $val;
    }

    /**
     * @return int
     */
    final public function make_response_header(): int {
        $headers = array_merge(self::$_global_http_headers, $this->_http_headers);

        foreach ($headers as $name => $value) {
            header("{$name}: $value");
        }

        return count($headers);
    }
}
