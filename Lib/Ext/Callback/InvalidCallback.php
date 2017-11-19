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
namespace Here\Lib\Ext\Callback;
use Here\Lib\Exceptions\ExceptionBase;
use Here\Lib\Exceptions\Level\Error;


/**
 * Class InvalidCallback
 * @package Here\Lib\Ext\Callback
 */
class InvalidCallback extends ExceptionBase {
    use Error;
}
