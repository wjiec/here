<?php
/**
 * DuplicateDefaultHandler.php
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
 * Class DuplicateDefaultHandler
 * @package Here\Lib\Router\Collector\Handler
 */
final class DuplicateDefaultHandler extends ExceptionBase {
    use Error;
}
