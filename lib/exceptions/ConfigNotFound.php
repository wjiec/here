<?php
/**
 * ConfigNotFound.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */

namespace Here\Lib\Exceptions;
use Here\Lib\Abstracts\ExceptionBase;
use Here\Lib\Exceptions\Level\Warning;

/**
 * Class ConfigNotFound
 * @package Here\Lib\Exceptions
 */
class ConfigNotFound extends ExceptionBase {
    use Warning;
}
