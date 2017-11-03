<?php
/**
 * AllowedChannelSyntax.php.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector\Channel;
use Here\Lib\Router\Collector\MetaSyntax\RouterComponentCommonSyntax;


/**
 * Class AllowedChannelSyntax
 * @package Lib\Router\Collector\Channel
 */
final class AllowedChannelSyntax extends RouterComponentCommonSyntax {
    /**
     * channel syntax: addUrl
     */
    public const CHANNEL_SYNTAX_ADD_URL = 'addUrl';

    /**
     * channel syntax: addMethods
     */
    public const CHANNEL_SYNTAX_ADD_METHODS = 'addMethods';

    /**
     * channel syntax: addMiddleware
     */
    public const CHANNEL_SYNTAX_ADD_MIDDLEWARE = 'addMiddleware';
}
