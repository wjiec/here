<?php
/**
 * MetaComponentNotFound.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector;
use Here\Lib\Exceptions\ExceptionBase;
use Here\Lib\Exceptions\Level\Warning;


/**
 * Class MetaComponentNotFound
 * @package Here\Lib\Router\Collector
 */
final class MetaComponentNotFound extends ExceptionBase {
    use Warning;
}
