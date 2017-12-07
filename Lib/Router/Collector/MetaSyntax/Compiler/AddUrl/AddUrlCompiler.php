<?php
/**
 * AddUrlCompiler.php.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl;
use Here\Lib\Ext\Stack\Stack;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\MetaSyntaxCompilerInterface;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\MetaSyntaxCompilerResultBase;


/**
 * Class AddUrlCompiler
 * @package Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl
 */
final class AddUrlCompiler implements MetaSyntaxCompilerInterface {
    /**
     * @param array $value
     * @return MetaSyntaxCompilerResultBase
     * @throws InvalidUrlRule
     * @throws \Here\Lib\Ext\Stack\EmptyStackError
     * @throws \Here\Lib\Router\Collector\MetaSyntax\Compiler\MetaSyntaxResultOverride
     */
    final public static function compile(array $value): MetaSyntaxCompilerResultBase {
        $add_url_component = new AddUrl();

        foreach ($value as $url_rule) {
            $valid_urls = self::_parse_rule($url_rule);
            foreach ($valid_urls as $valid_url) {
                $add_url_component->add_result($valid_url);
            }
        }

        return $add_url_component;
    }

    /**
     * @param string $url
     * @return ValidUrlObject
     * @throws InvalidUrlRule
     * @throws \Here\Lib\Ext\Stack\EmptyStackError
     */
    final private static function _parse_rule(string $url): ValidUrlObject {
        $characters = str_split($url);
        $characters[] = "\0";  // append `EOF` character

        // initial state
        $state_stack = new Stack();
        $state_stack->push(ParseStates::PARSE_STATE_START);

        // parse start
        $ret_object = new ValidUrlObject();
        foreach ($characters as $index => $character) {
            switch (true) {
                case ctype_alnum($character) || $character === '_';  // scalar character
                    break;
                case $character === '/':  // separator
                    ParserStateTransition::separator_transition($state_stack, $ret_object);
                    break;
                case $character === '<':  // variable path start
                    break;
                case $character === '>':  // variable path end
                    break;
                case $character === '[':  // optional path start
                    break;
                case $character === ']':  // optional path end
                    break;
                case $character === ':':  // regex pattern start
                    ParserStateTransition::regex_transition($state_stack, $ret_object);
                    break;
                case $character === '@':  // special character
                    break;
                case $character === '\\':  // escape character
                    break;
                case $character === "\0":  // EOF
                    break;
                default:
                    if ($state_stack->top() !== ParseStates::PARSE_STATE_REGEX_PATTERN) {
                        throw new InvalidUrlRule(sprintf("invalid char in position %s. `%s`", $index, $url));
                    }
            }
        }

        return $ret_object;
    }
}
