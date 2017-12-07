<?php
/**
 * ParserStateTransition.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl;
use Here\Lib\Ext\Stack\Stack;


/**
 * Class ParserStateTransition
 * @package Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl
 */
final class ParserStateTransition {
    /**
     * @param Stack $stack
     * @param ValidUrlObject $ret
     * @throws \Here\Lib\Ext\Stack\EmptyStackError
     */
    final public static function separator_transition(Stack $stack, ValidUrlObject $ret): void {
        if ($stack->top() === ParseStates::PARSE_STATE_START) {
            var_dump($stack, $ret);
        } else {
            var_dump($stack, $ret);
        }
    }

    /**
     * @param Stack $stack
     * @param ValidUrlObject $ret
     */
    final public static function regex_transition(Stack $stack, ValidUrlObject $ret): void {
        $stack->push(ParseStates::PARSE_STATE_REGEX_PATTERN);
    }
}
