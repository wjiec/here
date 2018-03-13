<?php
/**
 * ParameterOverrideError.php
 *
 * @package   here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Stream\IStream\Client\Parameters;
use Here\Lib\Exceptions\ExceptionBase;
use Here\Lib\Exceptions\Level\Warning;


/**
 * Class ParameterOverrideError
 * @package Here\Stream\IStream\Client\Parameters
 */
final class ParameterOverrideError extends ExceptionBase {
    use Warning;
}
