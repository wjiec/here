<?php
/**
 * AssertError.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Exceptions;
use Here\Lib\Exceptions\Level\Error;
use Here\Lib\Abstracts\ExceptionBase;


/**
 * Class AssertError
 * @package Here\Lib\Exception
 */
final class AssertError extends ExceptionBase {
    use Error;
}
