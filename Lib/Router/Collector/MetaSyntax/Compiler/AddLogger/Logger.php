<?php
/**
 * Logger.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector\MetaSyntax\Compiler\AddLogger;


/**
 * Class Logger
 * @package Here\Lib\Router\Collector\MetaSyntax\Compiler\AddLogger
 */
final class Logger {
    /**
     * @var string
     */
    private $_name;

    /**
     * @var string
     */
    private $_format;

    /**
     * Logger constructor.
     * @param string $name
     * @param string $format
     */
    final public function __construct(string $name, string $format) {
        $this->_name = $name;
        $this->_format = $format;
    }
}
