<?php
/**
 * FileStreamInvalid.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Lib\Stream;
use Here\Lib\Exceptions\ExceptionBase;
use Here\Lib\Exceptions\Level\Error;


/**
 * Class FileStreamInvalid
 * @package Lib\Stream
 */
final class FileStreamInvalid extends ExceptionBase {
    use Error;
}
