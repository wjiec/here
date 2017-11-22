<?php
/**
 * RuleInvalid.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\RuleParser;
use Here\Lib\Exceptions\ExceptionBase;
use Here\Lib\Exceptions\Level\Error;


/**
 * Class RuleInvalid
 * @package Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\RuleParser
 */
final class RuleInvalid extends ExceptionBase {
    use Error;
}
