<?php
/**
 * AllowedHandlerSyntax.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector\Handler;
use Here\Lib\Ext\Enum\EnumType;


/**
 * Class AllowedHandlerSyntax
 * @package Here\Lib\Router\Collector\Handler
 */
final class AllowedHandlerSyntax extends EnumType {
    /**
     * handler syntax: addHandler
     */
    public const HANDLER_SYNTAX_ADD_HANDLER = "addHandler";

    /**
     * handler syntax: defaultSyntax
     */
    public const HANDLER_SYNTAX_DEFAULT_HANDLER = "defaultHandler";
}
