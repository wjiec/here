<?php
/**
 * MetaComponent.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector;
use Here\Lib\Loader\Autoloader;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\CompilerNotFound;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\MetaSyntaxCompilerInterface;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\MetaSyntaxCompilerResultInterface;


/**
 * Class MetaComponent
 * @package Lib\Router\Collector
 */
trait MetaComponent {
    /**
     * @var array
     */
    private $_components;

    /**
     * @param string $name
     * @param MetaSyntaxCompilerResultInterface $value
     */
    final protected function add_component(string $name, MetaSyntaxCompilerResultInterface $value): void {
        // component_name => array( 'val1', 'val2', 'val3')
        $this->_components[$name] = $value;
    }

    /**
     * @param string $component_name
     * @return bool
     */
    final protected function has_component(string $component_name): bool {
        return isset($this->_components[ucfirst($component_name)]);
    }

    /**
     * @param $component_name
     * @return MetaSyntaxCompilerResultInterface|null
     */
    final protected function get_components($component_name): ?MetaSyntaxCompilerResultInterface {
        return $this->_components[ucfirst($component_name)] ?? null;
    }

    /**
     * @param array $allowed_syntax
     * @param array $meta
     * @throws CompilerNotFound
     */
    final protected function compile_components(array $allowed_syntax, array $meta): void {
        foreach ($meta as $syntax => $value) {
            if (in_array($syntax, $allowed_syntax)) {
                $syntax = ucfirst($syntax);
                /* @var MetaSyntaxCompilerInterface $compiler_name */
                $compiler_name = "Here\\Lib\\Router\\Collector\\MetaSyntax\\Compiler\\{$syntax}\\{$syntax}Compiler";
                if (!Autoloader::class_exists($compiler_name)) {
                    throw new CompilerNotFound("cannot found '{$syntax}' compiler, class => {$compiler_name}");
                }

                $this->add_component($syntax, call_user_func_array(
                    array($compiler_name, 'compile'), array($value)));
            }
        }
    }
}
