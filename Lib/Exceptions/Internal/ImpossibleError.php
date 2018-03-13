<?php
/**
 * ImpossibleError.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Exceptions\Internal;
use Here\Lib\Exceptions\ExceptionBase;
use Here\Lib\Exceptions\Level\Fatal;


/**
 * Class ImpossibleError
 * @package Here\Lib\Exceptions\Internal
 */
final class ImpossibleError extends ExceptionBase {
    use Fatal;
}
