<?php
/**
 * SysConstant.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Config\Constant;


/**
 * Class SysConstant
 * @package Here\Config\Constant
 */
final class SysConstant {
    /**
     * application name
     */
    public const HERE_NAME = 'Here';

    /**
     * blogger version
     */
    public const HERE_VERSION = array(0, 0, 1);

    /**
     * url separator
     */
    public const URL_SEPARATOR = '/';

    /**
     * path separator
     */
    public const PATH_SEPARATOR = '/';

    /**
     * items separator
     */
    public const ITEM_SEPARATOR = ',';

    /**
     * characters to generate random string
     */
    public const RANDOM_CHARACTERS = "abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";

    /**
     * default error code
     */
    public const DEFAULT_ERROR_CODE = 1996;
}
