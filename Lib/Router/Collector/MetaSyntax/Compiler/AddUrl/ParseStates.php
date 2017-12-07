<?php
/**
 * ParseStates.php
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
 * Class ParseStates
 * @package Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl
 */
final class ParseStates extends EnumType {
    /**
     * default state of parser
     */
    const __default = self::PARSE_STATE_START;

    /**
     * State: Start
     */
    public const PARSE_STATE_START = 0x0000;

    /**
     * State: End
     */
    public const PARSE_STATE_END = 0xFFFF;

    /**
     * State: Separator
     */
    public const PARSE_STATE_SEPARATOR = 0xEEEE;

    /**
     * State: ScalarPath
     */
    public const PARSE_STATE_SCALAR_PATH = 0xDDDD;

    /**
     * State: VarPathStart
     */
    public const PARSE_STATE_VAR_PATH_START = 0x1100;

    /**
     * State: VarPathEnd
     */
    public const PARSE_STATE_VAR_PATH_END = 0x0011;

    /**
     * State: OptionalPathStart
     */
    public const PARSE_STATE_OPT_PATH_START = 0x2200;

    /**
     * State: OptionalPathEnd
     */
    public const PARSE_STATE_OPT_PATH_END = 0x0022;

    /**
     * State: RegexPatternS
     */
    public const PARSE_STATE_REGEX_PATTERN = 0xAAAA;

    /**
     * State: NamedPath
     */
    public const PARSE_STATE_NAMED_PATH = 0xBBBB;
}
