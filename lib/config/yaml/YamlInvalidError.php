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
namespace Here\lib\config\yaml;
use Here\Lib\Abstracts\ExceptionBase;
use Here\Lib\Exceptions\Level\Warning;


/**
 * Class YamlInvalidError
 * @package Here\lib\config\yaml
 */
class YamlInvalidError extends ExceptionBase {
    use Warning;
}
