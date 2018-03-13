<?php
/**
 * IPNetworkError.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Utils\Network;
use Here\Lib\Exceptions\ExceptionBase;
use Here\Lib\Exceptions\Level\Error;


/**
 * Class IPNetworkError
 * @package Here\Lib\Utils\Network
 */
final class IPNetworkError extends ExceptionBase {
    use Error;
}
