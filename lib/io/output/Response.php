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
namespace Here\Lib\Io\Output;
use Here\Lib\Router\Router;


/**
 * Class Response
 * @package Here\Lib
 * @TODO
 */
final class Response {
    /**
     * fake 404 not found
     * @param bool $trigger_handler
     */
    final public static function fake_not_found($trigger_handler = true) {
        self::abort(404, $trigger_handler);
    }

    /**
     * @param string $key
     * @param string $value
     * @param bool $override
     * @param int $status_code
     */
    final public static function header($key, $value, $override = true, $status_code = 200) {
        header("{$key}: $value", $override, $status_code);
    }

    /**
     * @param int $status_code
     * @param bool $trigger_handler
     */
    final public static function abort($status_code, $trigger_handler = true) {
        // send status code to client
        self::header('Content-Type', 'text/html; charset=utf-8', false, $status_code);
        // check trigger error handler
        if ($trigger_handler) {
            Router::get_instance()->trigger_error($status_code);
        }
    }
}
