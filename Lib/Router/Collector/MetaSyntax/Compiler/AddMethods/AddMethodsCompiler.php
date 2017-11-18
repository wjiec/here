<?php
/**
 * AddMethodsCompiler.php.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector\MetaSyntax\Compiler\AddMethods;
use Here\Lib\Router\AllowedMethods;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\MetaSyntaxCompilerInterface;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\MetaSyntaxCompilerResultBase;


/**
 * Class AddMethodsCompiler
 * @package Here\Lib\Router\Collector\MetaSyntax\Compiler\AddMethods
 */
final class AddMethodsCompiler implements MetaSyntaxCompilerInterface {
    /**
     * @param array $value
     * @return MetaSyntaxCompilerResultBase
     */
    final public static function compile(array $value): MetaSyntaxCompilerResultBase {
        $add_methods_component = new AddMethods();

        foreach ($value as $method) {
            if (AllowedMethods::contains($method)) {
                $add_methods_component->add_result(AllowedMethods::standardize($method));
            }
        }

        return $add_methods_component;
    }
}
