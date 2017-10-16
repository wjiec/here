<?php
/**
 * AutoloaderError.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Loader;
use Here\Lib\Exceptions\ExceptionBase;
use Here\Lib\Exceptions\Level\Fatal;


/**
 * Class AutoloaderError
 * @package Here\Lib\Exception
 */
class AutoloaderError extends ExceptionBase {
    use Fatal;
}
