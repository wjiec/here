<?php
/**
 * UrlRuleParser.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\RuleParser;


/**
 * Class UrlRuleParser
 * @package Here
 *
 * httpurl        = "http://" hostport [ "/" hpath [ "?" search ]]
 * hpath          = hsegment *[ "/" hsegment ]
 * hsegment       = *[ uchar | ";" | ":" | "@" | "&" | "=" ]
 * uchar          = unreserved | escape
 * unreserved     = alpha | digit | safe | extra
 * alpha          = lowalpha | hialpha
 * lowalpha       = "a" | "b" | "c" | "d" | "e" | "f" | "g" | "h" |
 *                  "i" | "j" | "k" | "l" | "m" | "n" | "o" | "p" |
 *                  "q" | "r" | "s" | "t" | "u" | "v" | "w" | "x" |
 *                  "y" | "z"
 * hialpha        = "A" | "B" | "C" | "D" | "E" | "F" | "G" | "H" | "I" |
 *                  "J" | "K" | "L" | "M" | "N" | "O" | "P" | "Q" | "R" |
 *                  "S" | "T" | "U" | "V" | "W" | "X" | "Y" | "Z"
 * digit          = "0" | "1" | "2" | "3" | "4" | "5" | "6" | "7" | "8" | "9"
 * safe           = "$" | "-" | "_" | "." | "+"
 * extra          = "!" | "*" | "'" | "(" | ")" | ","
 * escape         = "%" hex hex
 * hex            = digit | "A" | "B" | "C" | "D" | "E" | "F" | "a" | "b" | "c" | "d" | "e" | "f"
 */
final class UrlRuleParser {
    /**
     * @var RuleState
     */
    private $_current_state;

    /**
     * @var array
     */
    private $_state_stack;

    /**
     * @var array
     */
    private $_inputs;

    /**
     * UrlRuleParser constructor.
     * @param string $rule
     */
    final public function __construct(string $rule) {
        $this->_current_state = new RuleState();
        $this->_state_stack = array();

        $this->_inputs = str_split($rule);
        $this->_inputs[] = "\0";  // EOF flag
    }

    /**
     * @return array
     * @throws RuleInvalid
     */
    final public function parse(): array {
        // check start input correct
        $start_input = array_shift($this->_inputs);
        if ($start_input !== self::RULE_START_CHARACTER) {
            throw new RuleInvalid("rule invalid of start character, position -> 0");
        }

        // foreach all character
        foreach ($this->_inputs as $index => $input) {
            echo htmlentities(sprintf("%s => %s\n", $index, $input));
            switch (true) {
                case $input === self::RULE_END_CHARACTER:
                    echo "EOF\n";
            }
        }

        return array();
    }

    /**
     * @param string $rule
     * @return UrlRuleParser
     */
    final public static function parser(string $rule): self {
        return new self($rule);
    }

    /**
     * start character of the rule
     */
    private const RULE_START_CHARACTER = "/";

    /**
     * footer character of the rule
     */
    private const RULE_END_CHARACTER = "\0";
}
