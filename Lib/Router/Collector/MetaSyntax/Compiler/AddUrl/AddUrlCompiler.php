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
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\RuleParser\UrlRuleParser;
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
     */
    final public static function compile(array $value): MetaSyntaxCompilerResultBase {
        $add_url_component = new AddUrl();

        foreach ($value as $url_rule) {
            // check is scalar type
            if (preg_match('/[\<\>\[\]]/', $url_rule, $matches) === 0) {
                $add_url_component->add_result(self::_parse_scalar(trim($url_rule)));
            } else {
                $add_url_component->add_result(self::_parse_complex(trim($url_rule)));
            }
        }

        return $add_url_component;
    }

    /**
     * @param string $url
     * @return string
     */
    final private static function _parse_scalar(string $url): string {
        $segments = explode('/', $url);
        $clean_url = join('/', array_filter($segments, function($segment): bool {
            return $segment !== '' || $segment !== null;
        }));

        return sprintf("/%s", $clean_url);
    }

    /**
     * @param string $url
     * @return string
     */
    final private static function _parse_complex(string $url): string {
        $parser = UrlRuleParser::parser($url);
        var_dump($parser, $parser->parse()); die();

        return $url;
    }
}
