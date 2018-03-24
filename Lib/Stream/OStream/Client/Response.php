<?php
/**
 * Response.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Stream\OStream\Client;
use Here\Lib\Environment\GlobalEnvironment;
use Here\Lib\Utils\Filter\Validator\TrueValidator;
use Here\Lib\Stream\OStream\Client\Component\ResponseHeader;


/**
 * Class Response
 * @package Here\Lib\Stream\OStream\Client
 */
class Response {
    /**
     * modify response headers
     */
    use ResponseHeader;

    /**
     * @param array ...$args
     */
    final public static function debug_output(...$args): void {
        if (TrueValidator::filter(GlobalEnvironment::get_user_env('debug_mode'))) {
            var_dump(...$args);
            OutputBuffer::commit_buffer();
        }
    }
}
