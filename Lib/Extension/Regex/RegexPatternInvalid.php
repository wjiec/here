<?php
/**
 * RegexPatternInvalid.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Extension\Regex;
use Here\Lib\Exceptions\ExceptionBase;
use Here\Lib\Exceptions\Level\Warning;


/**
 * Class RegexPatternInvalid
 * @package Here\Lib\Extensionension\Regex
 */
class RegexPatternInvalid extends ExceptionBase {
    use Warning;
}
