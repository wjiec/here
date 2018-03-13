<?php
/**
 * CompilerNotFound.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector\MetaSyntax\Compiler;
use Here\Lib\Exceptions\ExceptionBase;
use Here\Lib\Exceptions\Level\Error;


/**
 * Class CompilerNotFound
 * @package Lib\Router\Collector\MetaSyntax\Compiler
 */
final class CompilerNotFound extends ExceptionBase {
    use Error;
}
