<?php
/**
 * JwtGenerateSignatureError.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Utils\Jwt;
use Here\Lib\Exceptions\ExceptionBase;
use Here\Lib\Exceptions\Level\Error;


/**
 * Class JwtRsaSignatureError
 * @package Here\Lib\Utils\Jwt
 */
final class JwtGenerateSignatureError extends ExceptionBase {
    use Error;
}
