<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 10/20/2017
 * Time: 10:12
 */
namespace Here\Lib\Env;
use Here\Lib\Exceptions\ExceptionBase;
use Here\Lib\Exceptions\Level\Warning;


/**
 * Class EnvironmentOverride
 * @package Here\Env
 */
final class EnvironmentOverride extends ExceptionBase {
    use Warning;
}
