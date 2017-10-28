<?php
/**
 * ResponseHeaderOverrideError.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Stream\OStream\Client;
use Here\Lib\Exceptions\ExceptionBase;
use Here\Lib\Exceptions\Level\Warning;


/**
 * Class ResponseHeaderOverrideError
 * @package Here\Lib\Stream\OStream\Client
 */
final class ResponseHeaderOverrideError extends ExceptionBase {
    use Warning;
}
