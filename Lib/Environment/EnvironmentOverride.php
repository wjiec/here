<?php
/**
 * EnvironmentOverride.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Environment;
use Here\Lib\Exceptions\ExceptionBase;
use Here\Lib\Exceptions\Level\Warning;


/**
 * Class EnvironmentOverride
 * @package Here\Environment
 */
final class EnvironmentOverride extends ExceptionBase {
    use Warning;
}
