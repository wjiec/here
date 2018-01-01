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


/**
 * Class ResponseStatusCode
 * @package Here\Lib\Stream\OStream\Client
 */
trait ResponseStatusCode {
    /**
     * @param int $code
     */
    final public static function response_status_code(int $code): void {
        http_response_code($code);
    }
}
