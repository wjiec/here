<?php
/**
 * RuleParser.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\Rule;
use Here\Lib\Ext\Regex\Regex;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\Component\ComponentBuilder;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\Component\ScalarComponent;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\ValidUrl;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\ValidUrlType;
use Here\Lib\Utils\HereConstant;


/**
 * Class RuleParser
 * @package Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\Rule
 */
final class RuleParser {
    /**
     * @param string $rule
     * @return array
     * @throws InvalidRule
     * @throws \Here\Lib\Exceptions\Internal\ImpossibleError
     * @throws \Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\InvalidRule
     */
    final public static function parse(string $rule): array {
        $rule = rtrim($rule, HereConstant::URL_SEPARATOR);
        $segments = explode(HereConstant::URL_SEPARATOR, $rule);

        $valid_urls = array(new ValidUrl());
        /* @var ValidUrl $valid_url */
        $valid_url = &$valid_urls[0];

        $first_segment = array_shift($segments);
        if ($first_segment !== "") {
            throw new InvalidRule("the first character is not valid separator of url");
        }

        // root-routing rule
        if (empty($segments)) {
            $valid_url->add_component(
                new ScalarComponent(new Regex('/^$/'))
            );
        }

        // foreach parse all segment of url
        foreach ($segments as $segment) {
            /* @var ValidUrlType $type */ /* @var array $matches */
            $type = self::_try_match($segment, $matches);
            if (empty($matches)) {
                throw new InvalidRule("invalid segment('{$segment}') of rule('{$rule}')");
            }

            $valid_url->add_component(ComponentBuilder::build($type, $matches));
        }

        return $valid_urls;
    }

    /**
     * @param string $segment
     * @param mixed $result
     * @return ValidUrlType
     * @throws InvalidRule
     */
    final private static function _try_match(string $segment, &$result): ValidUrlType {
        $type = null;

        // scalar type
        if (($matches = self::_is_scalar($segment))) {
            $result = $matches;
            $type = new ValidUrlType(ValidUrlType::VALID_URL_TYPE_SCALAR_PATH);
        }

        // complex(variable & optional) segment | composite(scalar + (variable|optional)) segment
        if (($matches = self::_is_complex($segment)) || ($matches = self::_is_composite($segment))) {
            $sym_start = $matches['start'] ?? null;
            $sym_end = $matches['end'] ?? null;

            // check start-symbol and end-symbol is matched
            if ($sym_end !== self::SYMBOL_TABLE[$sym_start]) {
                throw new InvalidRule("the symbol of start and end not matched, segment('{$segment}')");
            }

            // is variable-segment
            if ($sym_start === self::VARIABLE_PATH_START_SYM) {
                $type = isset($matches['scalar'])
                    ? new ValidUrlType(ValidUrlType::VALID_URL_TYPE_COMPOSITE_VAR_PATH)
                    : new ValidUrlType(ValidUrlType::VALID_URL_TYPE_VARIABLE_PATH);
                $result = $matches;
            }

            // is optional-segment
            if ($sym_start === self::OPTIONAL_PATH_START_SYM) {
                $type = isset($matches['scalar'])
                    ? new ValidUrlType(ValidUrlType::VALID_URL_TYPE_COMPOSITE_VAR_PATH)
                    : new ValidUrlType(ValidUrlType::VALID_URL_TYPE_VARIABLE_PATH);
                $result = $matches;
            }
        }

        // full-matched segment
        if (($matches = self::_is_full_match($segment))) {
            $type = new ValidUrlType(ValidUrlType::VALID_URL_TYPE_FULL_MATCHED_PATH);
            $result = $matches;
        }

        // invalid segment
        if ($type === null) {
            throw new InvalidRule("invalid segment('{$segment}')");
        }

        return $type;
    }

    /**
     * @param string $segment
     * @return array
     */
    final private static function _is_scalar(string $segment): array {
        if (preg_match('/^(?<scalar>\w+)$/', $segment, $matches)) {
            return $matches;
        }
        return array();
    }

    /**
     * @param string $segment
     * @return array
     */
    final private static function _is_complex(string $segment): array {
        // only name part
        if (preg_match('/^(?<start>\<|\[)(?<name>\w+)\:?(?<end>\>|\])$/', $segment, $matches)) {
            return $matches;
        }

        // only pattern part
        if (preg_match('/^(?<start>\<|\[):(?<pattern>.*)(?<end>\>|\])$/', $segment, $matches)) {
            return $matches;
        }

        // both name and pattern
        if (preg_match('/^(?<start>\<|\[)(?<name>\w+)\:(?<pattern>.*)(?<end>\>|\])$/', $segment, $matches)) {
            return $matches;
        }

        return array();
    }

    /**
     * @param string $segment
     * @return array
     */
    final private static function _is_composite(string $segment): array {
        // only name part
        if (preg_match('/^(?<scalar>\w+)(?<start>\<|\[)(?<name>\w+)\:?(?<end>\>|\])$/', $segment, $matches)) {
            return $matches;
        }

        // only pattern part
        if (preg_match('/^(?<scalar>\w+)(?<start>\<|\[):(?<pattern>.*)(?<end>\>|\])$/', $segment, $matches)) {
            return $matches;
        }

        // both name and pattern
        if (preg_match(
            '/^(?<scalar>\w+)(?<start>\<|\[)(?<name>\w+)\:(?<pattern>.*)(?<end>\>|\])$/', $segment, $matches)
        ) {
            return $matches;
        }

        return array();
    }

    /**
     * @param string $segment
     * @return array
     */
    final private static function _is_full_match(string $segment): array {
        // only segment name
        if (preg_match('/^\{(?<name>\w+)\}$/', $segment, $matches)) {
            return $matches;
        }

        // both name and attributes
        if (preg_match('/^\{(?<name>\w+):(?<attributes>[A-Z0-9]+)\}$/', $segment, $matches)) {
            return $matches;
        }

        return array();
    }

    /**
     * start of variable path symbol
     */
    private const VARIABLE_PATH_START_SYM = '<';

    /**
     * end of variable path
     */
    private const VARIABLE_PATH_END_SYM = '>';

    /**
     * start of optional path symbol
     */
    private const OPTIONAL_PATH_START_SYM = '[';

    /**
     * end of optional path symbol
     */
    private const OPTIONAL_PATH_END_SYM = ']';

    /**
     * start of full matched symbol
     */
    private const FULL_MATCHED_START_SYM = '{';

    /**
     * end of full matched symbol
     */
    private const FULL_MATCHED_END_SYM = '}';

    /**
     * mapping of symbol
     */
    private const SYMBOL_TABLE = array(
        self::VARIABLE_PATH_START_SYM => self::VARIABLE_PATH_END_SYM,
        self::OPTIONAL_PATH_START_SYM => self::OPTIONAL_PATH_END_SYM,
        self::FULL_MATCHED_START_SYM => self::FULL_MATCHED_END_SYM
    );
}
