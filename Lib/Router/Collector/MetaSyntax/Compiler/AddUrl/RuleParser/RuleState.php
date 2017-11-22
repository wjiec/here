<?php
/**
 * RuleState.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\RuleParser;
use Here\Lib\Ext\Enum\EnumType;


/**
 * Class RuleState
 * @package Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\RuleParser
 */
final class RuleState extends EnumType {
    /**
     * default state
     */
    public const __default = self::RULE_STATE_START;

    /**
     * rule state: START
     */
    public const RULE_STATE_START = 0x0000;

    /**
     * rule state: END
     */
    public const RULE_STATE_END = 0xffff;

    /**
     * rule state: SCALAR
     */
    public const RULE_STATE_SCALAR = 0x0001;

    /**
     * rule state: REQUIRED START
     */
    public const RULE_STATE_REQUIRED_START = 0x0002;

    /**
     * rule state: REQUIRED END
     */
    public const RULE_STATE_REQUIRED_END = 0x0004;

    /**
     * rule state: OPTIONAL START
     */
    public const RULE_STATE_OPTIONAL_START = 0x0008;

    /**
     * rule state: OPTIONAL END
     */
    public const RULE_STATE_OPTIONAL_END = 0x0010;

    /**
     * rule state: named
     */
    public const RULE_STATE_NAMED = 0x0020;

    /**
     * rule state: REGEX START
     */
    public const RULE_STATE_REGEX_START = 0x0040;

    /**
     * rule state: REGEX END
     */
    public const RULE_STATE_REGEX_END = 0x0080;

    /**
     * rule state: REGEX END
     */
    public const RULE_STATE_ESCAPE_START = 0x0100;
}
