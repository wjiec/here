<?php
/**
 * DatabaseModelNotFound.php
 *
 * @package   here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Database\Model;
use Here\Lib\Exceptions\ExceptionBase;
use Here\Lib\Exceptions\Level\Error;


/**
 * Class DatabaseModelNotFound
 *
 * @package Here\Lib\Database\Model
 */
final class DatabaseModelNotFound extends ExceptionBase {
    use Error;
}
