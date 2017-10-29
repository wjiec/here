<?php
/**
 * ResponseStatusCode.php
 *
 * @package   here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Stream\OStream\Client\Component;
use Here\Lib\Http\HttpStatusCode;


/**
 * Class ResponseStatusCode
 * @package Here\Lib\Stream\OStream\Client
 */
trait ResponseStatusCode {
    /**
     * @var HttpStatusCode
     */
    private $_http_status_code;

    /**
     * @param HttpStatusCode $code
     */
    final public function response_status_code(HttpStatusCode $code): void {
        $this->_http_status_code = $code;
    }

    /**
     * @return int
     */
    final public function make_response_status_code(): int {
        \http_response_code($this->_http_status_code->value());
        return $this->_http_status_code->value();
    }
}
