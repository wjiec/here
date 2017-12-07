<?php
/**
 * InvalidUrlRule.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl;
use Here\Lib\Exceptions\ExceptionBase;
use Here\Lib\Exceptions\Level\Error;


/**
 * Class InvalidUrlRule
 * @package Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl
 */
final class InvalidUrlRule extends ExceptionBase {
    use Error;
}
