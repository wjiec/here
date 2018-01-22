<?php
/**
 * AddLoggerCompiler.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector\MetaSyntax\Compiler\AddLogger;
use Here\Config\Constant\DefaultConstant;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\MetaSyntaxCompilerInterface;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\MetaSyntaxCompilerResultBase;


/**
 * Class AddLoggerCompiler
 * @package Here\Lib\Router\Collector\MetaSyntax\Compiler\AddLogger
 */
final class AddLoggerCompiler implements MetaSyntaxCompilerInterface {
    /**
     * @param array $value
     * @return MetaSyntaxCompilerResultBase
     * @throws \Here\Lib\Router\Collector\MetaSyntax\Compiler\MetaSyntaxResultOverride
     */
    final public static function compile(array $value): MetaSyntaxCompilerResultBase {
        $add_logger = new AddLogger();

        foreach ($value as $logger) {
            $matches = null;

            do {
                if (preg_match('/^(?<name>\w+)/', $logger, $matches)) {
                    break;
                }

                if (preg_match('/^(?<name>\w+)\s*\"(?<format>.*)\"/', $logger, $matches)) {
                    break;
                }
            } while(0);

            $logger_name = $matches['name'] ?? DefaultConstant::DEFAULT_LOGGER_NAME;
            $logger_format = $matches['format'] ?? DefaultConstant::DEFAULT_LOGGER_FORMAT;
            $add_logger->add_result(new Logger($logger_name, $logger_format));
        }

        return $add_logger;
    }
}
