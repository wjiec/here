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
    private static $_static_http_headers;

    /**
     * @var array
     */
    private $_http_headers;

    /**
     * @param int $code
     */
    final public static function response_status_code(int $code): void {
        http_response_code($code);
    }

    /**
     * @param string $name
     * @param string $val
     * @param bool $override
     * @throws ResponseHeaderOverrideError
     */
    final public static function static_response_header(string $name, string $val, bool $override = false): void {
        if (!$override && isset(self::$_static_http_headers[$name])) {
            throw new ResponseHeaderOverrideError("cannot override '{$name}' header");
        }

        self::$_static_http_headers[$name] = $val;
    }

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
     * clean pre-define headers
     */
    final public function clean_headers(): void {
        $this->_http_headers = array();
    }

    /**
     * @return int
     */
    final public function commit_response_header(): int {
        $headers = array_merge(self::$_static_http_headers, $this->_http_headers);

        foreach ($headers as $name => $value) {
            header("{$name}: $value");
        }

        return count($headers);
    }
}
