<?php
/**
 * This file is part of here
 *
 * @copyright Copyright (C) 2020 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/wjiec/here
 */
namespace Here\Provider\VoltExtension;

use Bops\Mvc\View\Engine\Volt\Extension\AbstractExtension;


/**
 * Class Functions
 * @package Here\Provider\Volt
 */
class Functions extends AbstractExtension {

    /**
     * Compile any function call in a template.
     *
     * @noinspection PhpUnused
     * @param string $name
     * @param mixed $arguments
     * @param array[] $args
     * @return string|null
     */
    public function compileFunction(string $name, $arguments, $args): ?string {
        switch ($name) {
            case 'join':
                return "join(',', {$arguments})";
            case '_t':
                return sprintf('$this->translator->t(%s)', $arguments);
            case 'exp':
                return sprintf('(!empty(%s) ? (%s) : (%s))', $this->compiler->expression($args[0]['expr']),
                    $this->compiler->expression($args[1]['expr']), $this->compiler->expression($args[2]['expr']));
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
    public function compileFilter(string $name, $arguments): ?string {
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