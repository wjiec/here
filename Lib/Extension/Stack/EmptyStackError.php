<?php
/**
 * EmptyStackError.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Extension\Stack;
use Here\Lib\Exceptions\ExceptionBase;
use Here\Lib\Exceptions\Level\Error;


/**
 * Class EmptyStackError
 * @package Here\Lib\Extensionension\Stack
 */
final class EmptyStackError extends ExceptionBase {
    use Error;
}
