<?php
/**
 * ValidUrlType.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl;
use Here\Lib\Ext\Enum\EnumType;


/**
 * Class ValidUrlType
 * @package Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl
 */
final class ValidUrlType extends EnumType {
    /**
     * default valid type of url
     */
    public const __default = self::VALID_URL_TYPE_SCALAR_PATH;

    /**
     * scalar_path
     */
    public const VALID_URL_TYPE_SCALAR_PATH = 0x0001;

    /**
     * variable path
     */
    public const VALID_URL_TYPE_VARIABLE_PATH = 0x0002;

    /**
     * optional path
     */
    public const VALID_URL_TYPE_OPTIONAL_PATH = 0x0004;

    /**
     * composite path
     */
    public const VALID_URL_TYPE_COMPOSITE_VAR_PATH = 0x0008;

    /**
     * composite path
     */
    public const VALID_URL_TYPE_COMPOSITE_OPT_PATH = 0x0010;

    /**
     * full-matched path
     */
    public const VALID_URL_TYPE_FULL_MATCHED_PATH = 0xFFFF;
}
