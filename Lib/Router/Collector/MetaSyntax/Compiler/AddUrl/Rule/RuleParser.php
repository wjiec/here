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
use Here\Lib\Extension\Regex\Regex;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\Component\ComponentBuilder;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\Component\ScalarComponent;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\ValidUrl;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\ValidUrlType;
use Here\Config\Constant\SysConstant;


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
        $rule = rtrim($rule, SysConstant::URL_SEPARATOR);
        $segments = explode(SysConstant::URL_SEPARATOR, $rule);

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
            $type = self::try_match($segment, $matches);
            if (empty($matches)) {
                throw new InvalidRule("invalid segment('{$segment}') of rule('{$rule}')");
            }

            $valid_url->add_component(ComponentBuilder::build($type, $matches));
        }

        // clone valid_url is last component is OPTIONAL-RULE
        if ($valid_url->last_component_type()->value() === ValidUrlType::VALID_URL_TYPE_OPTIONAL_PATH) {
            $new_valid_url = clone $valid_url;
            $new_valid_url->pop_last();

            $valid_urls[] = $new_valid_url;
        }

        return $valid_urls;
    }

    /**
     * @param ValidUrl $valid_url
     * @return bool
     */
    final public static function is_end_component(ValidUrl $valid_url): bool {
        $last_component_type = $valid_url->last_component_type();
        return in_array($last_component_type->value(), self::END_COMPONENT);
    }

    /**
     * @param string $segment
     * @param mixed $result
     * @return ValidUrlType
     * @throws InvalidRule
     */
    final private static function try_match(string $segment, &$result): ValidUrlType {
        $type = null;

        // scalar type
        if (($matches = self::is_scalar($segment))) {
            $result = $matches;
            $type = new ValidUrlType(ValidUrlType::VALID_URL_TYPE_SCALAR_PATH);
        }

        // complex(variable & optional) segment | composite(scalar + (variable|optional)) segment
        if (($matches = self::is_complex($segment)) || ($matches = self::is_composite($segment))) {
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
                    ? new ValidUrlType(ValidUrlType::VALID_URL_TYPE_COMPOSITE_OPT_PATH)
                    : new ValidUrlType(ValidUrlType::VALID_URL_TYPE_OPTIONAL_PATH);
                $result = $matches;
            }
        }

        // full-matched segment
        if (($matches = self::is_full_match($segment))) {
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
    final private static function is_scalar(string $segment): array {
        if (preg_match('/^(?<scalar>[\w\&\-]+)$/', $segment, $matches)) {
            return $matches;
        }
        return array();
    }

    /**
     * @param string $segment
     * @return array
     */
    final private static function is_complex(string $segment): array {
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
    final private static function is_composite(string $segment): array {
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
    final private static function is_full_match(string $segment): array {
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

    /**
     * follow component must in the end of segments
     */
    private const END_COMPONENT = array(
        ValidUrlType::VALID_URL_TYPE_OPTIONAL_PATH,
        ValidUrlType::VALID_URL_TYPE_COMPOSITE_OPT_PATH,
        ValidUrlType::VALID_URL_TYPE_FULL_MATCHED_PATH
    );
}
