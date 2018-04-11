<?php
/**
 * DatabaseAdapterNotFound.php
 *
 * @package   here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Database\Adapter;
use Here\Lib\Exceptions\ExceptionBase;
use Here\Lib\Exceptions\Level\Error;


/**
 * Class DatabaseAdapterNotFound
 *
 * @package Here\Lib\Database\Adapter
 */
final class DatabaseAdapterNotFound extends ExceptionBase {
    use Error;
}
