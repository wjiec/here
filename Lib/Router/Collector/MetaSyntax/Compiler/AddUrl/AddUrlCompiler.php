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
use Here\Lib\Router\Collector\MetaSyntax\Compiler\MetaSyntaxCompilerInterface;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\MetaSyntaxCompilerResultBase;
use Here\Lib\Utils\HereConstant;


/**
 * Class AddUrlCompiler
 * @package Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl
 */
final class AddUrlCompiler implements MetaSyntaxCompilerInterface {
    /**
     * @param array $value
     * @return MetaSyntaxCompilerResultBase
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
     * @return array|ValidUrl[]
     */
    final private static function _parse_url(string $url): array {
        return array(new ValidUrl());
    }
}
