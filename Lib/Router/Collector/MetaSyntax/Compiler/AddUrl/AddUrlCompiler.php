<?php
/**
 * AddUrlCompiler.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\Rule\RuleParser;
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
     * @throws InvalidRule
     * @throws Rule\InvalidRule
     * @throws \Here\Lib\Exceptions\Internal\ImpossibleError
     * @throws \Here\Lib\Router\Collector\MetaSyntax\Compiler\MetaSyntaxResultOverride
     */
    final public static function compile(array $value): MetaSyntaxCompilerResultBase {
        $add_url_component = new AddUrl();

        foreach ($value as $rule) {
            /* @var ValidUrl $valid_url */
            foreach (RuleParser::parse($rule) as $valid_url) {
                $add_url_component->add_result($valid_url);
            }
        }

        return $add_url_component;
    }
}
