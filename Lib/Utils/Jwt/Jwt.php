<?php
/**
 * Jwt.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Utils\Jwt;


/**
 * Class Jwt
 * @package Here\Lib\Utils\Jwt
 */
final class Jwt {
    /**
     * generator
     */
    use JwtGenerator;

    /**
     * parser
     */
    use JwtParser;
}
