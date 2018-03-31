<?php
/**
 * AdapterNotFound.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Cache\Adapter;
use Here\Lib\Exceptions\ExceptionBase;
use Here\Lib\Exceptions\Level\Error;


/**
 * Class AdapterNotFound
 * @package Here\Lib\Cache\Adapter
 */
final class AdapterNotFound extends ExceptionBase {
    use Error;
}
