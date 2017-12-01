<?php
/**
 * JwtAlgorithmType.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Utils\Jwt;
use Here\Lib\Ext\Enum\EnumType;


/**
 * Class JwtType
 * @package Here\Lib\Utils\Jwt
 */
final class JwtAlgorithmType extends EnumType {
    /**
     * default jwt type
     */
    public const __default = self::JWT_TYPE_HS256;

    /**
     * jwt type: HS256
     */
    public const JWT_TYPE_HS256 = 'HS256';

    /**
     * jwt type: HS384
     */
    public const JWT_TYPE_HS384 = 'HS384';

    /**
     * jwt type: HS512
     */
    public const JWT_TYPE_HS512 = 'HS512';

    /**
     * jwt type: RS256
     */
    public const JWT_TYPE_RS256 = 'RS256';

    /**
     * jwt type: RS384
     */
    public const JWT_TYPE_RS384 = 'RS384';

    /**
     * jwt type: RS512
     */
    public const JWT_TYPE_RS512 = 'RS512';
}
