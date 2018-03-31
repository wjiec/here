<?php
/**
 * InvalidCacheServerConfig.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Cache\Config;
use Here\Lib\Exceptions\ExceptionBase;
use Here\Lib\Exceptions\Level\Error;


/**
 * Class InvalidCacheServerConfig
 * @package Here\Lib\Cache\Config
 */
final class InvalidCacheServerConfig extends ExceptionBase {
    use Error;
}
