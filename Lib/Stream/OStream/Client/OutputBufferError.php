<?php
/**
 * OutputBufferError.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Stream\OStream\Client;
use Here\Lib\Exceptions\ExceptionBase;
use Here\Lib\Exceptions\Level\Warning;


/**
 * Class OutputBufferError
 * @package Here\Lib\Stream\OStream\Client\Component
 */
final class OutputBufferError extends ExceptionBase {
    use Warning;
}
