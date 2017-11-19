<?php
/**
 * MiddlewareAliasNotFound.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector\Middleware;
use Here\Lib\Exceptions\ExceptionBase;
use Here\Lib\Exceptions\Level\Warning;


/**
 * Class MiddlewareAliasNotFound
 * @package Here\Lib\Router\Collector\Middleware
 */
final class MiddlewareAliasNotFound extends ExceptionBase {
    use Warning;
}
