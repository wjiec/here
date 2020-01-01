<?php
/**
 * here application
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.org>
 * @copyright Copyright (C) 2016-2019 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/lsalio/here
 */
namespace Here\Provider\Volt;


/**
 * Class Functions
 * @package Here\Provider\Volt
 */
final class Functions {

    /**
     * Compile any function call in a template.
     *
     * @noinspection PhpUnused
     * @param string $name
     * @param mixed $arguments
     * @return string|null
     */
    final public function compileFunction(string $name, $arguments): ?string {
        switch ($name) {
            case 'join':
                return "join(',', {$arguments})";
            case '_t':
                return sprintf('$this->translator->t(%s)', $arguments);
            default:
                return null;
        }
    }

    /**
     * Compile some filters
     *
     * @noinspection PhpUnused
     * @param string $name
     * @param $arguments
     * @return string|null
     */
    final public function compileFilter(string $name, $arguments): ?string {
        switch ($name) {
            case 'markdown':
                return sprintf('$this->markdown->parse(%s)', $arguments);
            case 'security_markdown':
                return sprintf('$this->markdown->setSafeMode(true)->setMarkupEscaped(true)->parse(%s)', $arguments);
            case 'date':
                return sprintf('date("F d, Y", strtotime(%s))', $arguments);
            case 'avatar':
                return sprintf('$this->avatar->getUrl(%s)', $arguments);
            default:
                return null;
        }
    }

}
