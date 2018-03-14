<?php
/**
 * InvalidCallback.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Extension\Callback;
use Here\Lib\Exceptions\ExceptionBase;
use Here\Lib\Exceptions\Level\Error;


/**
 * Class InvalidCallback
 * @package Here\Lib\Extensionension\Callback
 */
class InvalidCallback extends ExceptionBase {
    use Error;
}
