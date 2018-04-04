<?php
/**
 * JsonConfigInvalid.php.php
 *
 * @package   here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Config\Parser\Json;
use Here\Lib\Exceptions\ExceptionBase;
use Here\Lib\Exceptions\Level\Error;


/**
 * Class JsonConfigInvalid
 *
 * @package Here\Lib\Config\Parser\Json
 */
final class JsonConfigInvalid extends ExceptionBase {
    use Error;
}
