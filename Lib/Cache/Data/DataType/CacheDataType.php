<?php
/**
 * CacheDataType.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Cache\Data\DataType;
use Here\Lib\Extension\Enum\EnumType;


/**
 * Class CacheDataType
 * @package Here\Lib\Cache\Data\DataType
 */
final class CacheDataType extends EnumType {
    /**
     * default: NOT_FOUND
     */
    public const __default = self::CACHE_TYPE_NONE;

    /**
     * string type
     */
    public const CACHE_TYPE_STRING = 0;

    /**
     * list type
     */
    public const CACHE_TYPE_LIST = 1;

    /**
     * hash type
     */
    public const CACHE_TYPE_HASH = 2;

    /**
     * `set` type
     */
    public const CACHE_TYPE_SET = 4;

    /**
     * order-set type
     */
    public const CACHE_TYPE_ORDER_SET = 8;

    /**
     * type not found
     */
    public const CACHE_TYPE_NONE = 255;
}
