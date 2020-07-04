<?php
/**
 * This file is part of here
 *
 * @noinspection PhpUnused, PhpUnusedParameterInspection
 *
 * @copyright Copyright (C) 2020 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/wjiec/here
 */
namespace Here\Library\Mvc\View\Volt;

use Bops\Mvc\View\Engine\Volt\Extension\AbstractExtension;
use Phalcon\Text;


/**
 * Class Extension
 *
 * @package Here\Library\Mvc\View\Volt
 */
class Extension extends AbstractExtension {

    /**
     * Compile any function call in a template
     *
     * @param string $name
     * @param mixed $arguments
     * @param mixed $args
     * @return string|null
     */
    public function compileFunction(string $name, $arguments, $args) {
        $method = sprintf('function%s', ucfirst(Text::camelize($name)));
        if (method_exists($this, $method)) {
            return $this->{$method}($arguments, $args);
        }
        return null;
    }

    /**
     * Compile some filters
     *
     * @noinspection PhpUnused
     * @param string $name
     * @param $arguments
     * @return string|null
     */
    public function compileFilter(string $name, $arguments) {
        $method = sprintf('filter%s', ucfirst(Text::camelize($name)));
        if (method_exists($this, $method)) {
            return $this->{$method}($arguments);
        }
        return null;
    }

    /**
     * string join
     *
     * @param mixed $arguments
     * @param mixed $args
     * @return string
     */
    protected function functionJoin($arguments, $args) {
        return "join(',', {$arguments})";
    }

    /**
     * translate keyword
     *
     * @param mixed $arguments
     * @param mixed $args
     * @return string
     */
    protected function functionT($arguments, $args) {
        return sprintf('$this->translator->t(%s)', $arguments);
    }

}
