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


use Phalcon\Mvc\View\Engine\Volt\Compiler;

/**
 * Class Functions
 * @package Here\Provider\Volt
 */
class Functions {

    /**
     * @var Compiler
     */
    protected $compiler;

    /**
     * Functions constructor.
     * @param Compiler $compiler
     */
    public function __construct(Compiler $compiler) {
        $this->compiler = $compiler;
    }

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
