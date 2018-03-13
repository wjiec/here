<?php
/**
 * UndefinedErrorCode.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector\MetaSyntax\Compiler\AddHandler;
use Here\Lib\Exceptions\ExceptionBase;
use Here\Lib\Exceptions\Level\Warning;


/**
 * Class UndefinedErrorCode
 * @package Here\Lib\Router\Collector\MetaSyntax\Compiler\AddHandler
 */
final class UndefinedErrorCode extends ExceptionBase {
    use Warning;
}
