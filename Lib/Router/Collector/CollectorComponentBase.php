<?php
/**
 * CollectorComponentBase.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector;
use Here\Lib\Router\Collector\MetaSyntax\MetaSyntaxCompiler;
use Here\Lib\Router\RouterCallback;


/**
 * Class CollectorComponentBase
 * @package Here\Lib\Router\Collector
 */
abstract class CollectorComponentBase implements CollectorComponentInterface {
    /**
     * meta compiler
     */
    use MetaSyntaxCompiler;

    /**
     * @var string
     */
    private $_component_name;

    /**
     * @var RouterCallback;
     */
    private $_component_callback;

    /**
     * CollectorComponentBase constructor.
     * @param string $name
     * @param array $meta
     * @param RouterCallback $callback
     * @throws MetaSyntax\Compiler\CompilerNotFound
     */
    public function __construct(string $name, array $meta, RouterCallback $callback) {
        $this->_component_name = $name;
        $this->_component_callback = $callback;

        $this->compile_components($this->allowed_syntax(), $meta);
    }

    /**
     * @return string
     */
    final public function get_component_name(): string {
        return $this->_component_name;
    }

    /**
     * @param array ...$args
     * @return mixed
     * @throws \ArgumentCountError
     */
    final public function apply_callback(...$args) {
        return $this->_component_callback->apply(...$args);
    }

    /**
     * @return array
     */
    abstract protected function allowed_syntax(): array;
}
