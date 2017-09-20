<?php
/**
 * MethodNotAllowed.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router;
use Here\Lib\Exceptions\ExceptionBase;
use Here\Lib\Exceptions\Level\Error;


/**
 * Class MethodNotAllowed
 * @package Here\Lib\Router
 */
class MethodNotAllowed extends ExceptionBase {
    use Error;
}
