<?php
/**
 * DuplicateMiddleware.php
 *
 * @package   www
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector\Middleware;
use Here\Lib\Exceptions\ExceptionBase;
use Here\Lib\Exceptions\Level\Error;


/**
 * Class DuplicateMiddleware
 * @package Here\Lib\Router\Collector\Middleware
 */
final class DuplicateMiddleware extends ExceptionBase {
    use Error;
}
