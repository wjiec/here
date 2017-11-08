<?php
/**
 * MetaComponent.php.php
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


/**
 * Class MetaComponent
 * @package Lib\Router\Collector
 */
abstract class MetaComponent {
    /**
     * @var array
     */
    private $_components;

    /**
     * @var string
     */
    private $_component_name;

    /**
     * @param string $name
     * @return array
     */
    final public function get_component(string $name): array {
        return $this->_components[$name] ?? array();
    }

    /**
     * @return string
     */
    final public function get_component_name(): string {
        return $this->_component_name;
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    final protected function add_component(string $name, $value): void {
        $this->_components[$name] = $value;
    }

    /**
     * @param string $name
     */
    final protected function set_component_name(string $name): void {
        $this->_component_name = $name;
    }

    /**
     * @param array $allowed_syntax
     * @param array $meta
     */
    final protected function compile_values(array $allowed_syntax, array $meta): void {
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
