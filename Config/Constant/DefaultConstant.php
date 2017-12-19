<?php
/**
 * DefaultConstant.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Config\Constant;


/**
 * Class DefaultConstant
 * @package Here\Config\Constant
 */
final class DefaultConstant {
    /**
     * default charset
     */
    public const DEFAULT_CHARSET = "utf-8";

    /**
     * default format for date
     *  * 2017-12-17
     */
    public const DEFAULT_DATE_FORMAT = "Y-m-d";

    /**
     * default format for time
     *  * 19:45:03:322-PRC
     */
    public const DEFAULT_TIME_FORMAT = "H:i:s:u-e";

    /**
     * default logger name
     */
    public const DEFAULT_LOGGER_NAME = "DefaultLogger";

    /**
     * default format for logger
     */
    public const DEFAULT_LOGGER_FORMAT = "%date %time: %addr %url%is_query%query";
}
