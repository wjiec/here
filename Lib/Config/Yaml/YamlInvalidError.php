<?php
/**
 * YamlInvalidError.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\config\yaml;
use Here\Lib\Exceptions\ExceptionBase;
use Here\Lib\Exceptions\Level\Warning;


/**
 * Class YamlInvalidError
 * @package Here\Lib\config\yaml
 */
class YamlInvalidError extends ExceptionBase {
    use Warning;
}
