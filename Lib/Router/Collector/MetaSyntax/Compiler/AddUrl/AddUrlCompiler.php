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
use Here\Lib\Ext\Regex\Regex;
use Here\Lib\Utils\HereConstant;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\MetaSyntaxCompilerInterface;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\MetaSyntaxCompilerResultBase;


/**
 * @TODO
 *  1. /rule/ and /rule
 */

/**
 * Class AddUrlCompiler
 * @package Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl
 */
final class AddUrlCompiler implements MetaSyntaxCompilerInterface {
    /**
     * @param array $value
     * @return MetaSyntaxCompilerResultBase
     * @throws InvalidRule
     * @throws \Here\Lib\Router\Collector\MetaSyntax\Compiler\MetaSyntaxResultOverride
     */
    final public static function compile(array $value): MetaSyntaxCompilerResultBase {
        $add_url_component = new AddUrl();

        foreach ($value as $url_rule) {
            foreach (self::_parse_url($url_rule) as $item) {
                $add_url_component->add_result($item);
            }
        }

        return $add_url_component;
    }

    /**
     * @param string $url
     * @return array
     * @throws InvalidRule
     */
    final private static function _parse_url(string $url): array {
        $segments = explode(HereConstant::URL_SEPARATOR, $url);
        $valid_urls = array(new ValidUrl());
        /* @var ValidUrl $valid_url */
        $valid_url = &$valid_urls[0];

        $first_segment = array_shift($segments);
        if ($first_segment !== "") {
            throw new InvalidRule("the first character is not valid separator of url");
        }

        if (empty($segments)) {  // root
            $valid_url->scalar_component(new Regex('/^$/'));
        }

        // parse each part of URL by separator('/')
        foreach ($segments as $index => $segment) {
            if (($matches = self::_parse_scalar_path($segment)) && !empty($matches)) {  // scalar path
                $valid_url->scalar_component(new Regex(sprintf('/^%s$/', $matches['scalar'])));
            } else if (($matches = self::_parse_complex_path($segment)) && !empty($matches)) {  // complex path
                $sym_start = $matches['start'] ?? null;
                $sym_end = $matches['end'] ?? null;

                if (!$sym_start || !$sym_end || self::SYMBOL_TABLE[$sym_start] !== $sym_end) {
                    throw new InvalidRule("the symbol of start and end not matched, segment('{$segment}')");
                }

                $valid_url->complex_component(
                    new ValidUrlType($sym_start === self::VARIABLE_PATH_START_SYM
                        ? ValidUrlType::VALID_URL_TYPE_VARIABLE_PATH
                        : ValidUrlType::VALID_URL_TYPE_OPTIONAL_PATH
                    ),
                    new Regex(sprintf('/^%s$/', $matches['pattern'])),
                    $matches['name'] ?? null
                );
            } else if (($matches = self::_parse_composite_path($segment)) && !empty($matches)) {  // composite path
                $sym_start = $matches['start'] ?? null;
                $sym_end = $matches['end'] ?? null;

                if (!$sym_start || !$sym_end || self::SYMBOL_TABLE[$sym_start] !== $sym_end) {
                    throw new InvalidRule("the symbol of start and end not matched, segment('{$segment}')");
                }

                $valid_url->composite_component(
                    new ValidUrlType($sym_start === self::VARIABLE_PATH_START_SYM
                        ? ValidUrlType::VALID_URL_TYPE_COMPOSITE_VAR_PATH
                        : ValidUrlType::VALID_URL_TYPE_COMPOSITE_OPT_PATH
                    ),
                    $matches['scalar'],
                    new Regex(sprintf('/^%s$/', $matches['pattern'])),
                    $matches['name'] ?? null
                );
            } else if (($matches = self::_parse_full_matched_path($segment)) && !empty($matches)) {  // full-match path
                $valid_url->full_matched_component(
                    $matches['name'],
                    $matches['attributes'] ?? null
                );
            } else {
                throw new InvalidRule("valid segment, ('{$segment}')");
            }

            $last_component = $valid_url->last_component_type()->value();
            if (in_array($last_component, self::END_COMPONENT)) {
                if ($index !== count($segments) - 1) {
                    throw new InvalidRule("segment ('{$segment}') must on the end of rule)");
                } else {
                    // clone an optional rule
                    $clone_valid_url = clone $valid_url;

                    // add scalar component
                    $component = $clone_valid_url->pop_last();
                    $clone_valid_url->scalar_component(
                        new Regex(sprintf('/^%s$/', $component->scalar))
                    );

                    $valid_urls[] = $clone_valid_url;
                }
            }
        }

        return $valid_urls;
    }

    /**
     * @param string $segment
     * @return array
     */
    final private static function _parse_scalar_path(string $segment): array {
        if (preg_match('/^(?<scalar>\w+)$/', $segment, $matches)) {
            return $matches;
        }
        return array();
    }

    /**
     * @param string $segment
     * @return array
     */
    final private static function _parse_complex_path(string $segment): array {
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
    final private static function _parse_composite_path(string $segment): array {
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
    final private static function _parse_full_matched_path(string $segment): array {
        if (preg_match('/^\{(?<name>\w+)\}$/', $segment, $matches)) {
            return $matches;
        }

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
     * follow component must on the end of rule
     */
    private const END_COMPONENT = array(
        ValidUrlType::VALID_URL_TYPE_OPTIONAL_PATH,
        ValidUrlType::VALID_URL_TYPE_COMPOSITE_OPT_PATH,
        ValidUrlType::VALID_URL_TYPE_FULL_MATCHED_PATH
    );
}
