<?php
/**
 * InvalidRouterHandler.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector\Handler;
use Here\Lib\Exceptions\ExceptionBase;
use Here\Lib\Exceptions\Level\Error;


/**
 * Class InvalidRouterHandler
 * @package Here\Lib\Router\Collector\Handler
 */
final class InvalidRouterHandler extends ExceptionBase {
    use Error;
}
