<?php
/**
 * InvalidChannel.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector\Channel;
use Here\Lib\Exceptions\ExceptionBase;
use Here\Lib\Exceptions\Level\Error;


/**
 * Class InvalidChannel
 * @package Here\Lib\Router\Collector\Channel
 */
class InvalidChannel extends ExceptionBase {
    use Error;
}
