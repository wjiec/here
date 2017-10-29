<?php
/**
 * RouterTypeAnalyzer.php
 *
 * @package   here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector\Generator;


/**
 * Class RouterTypeAnalyzer
 * @package Here\Lib\Router\Collector\Generator
 */
final class RouterTypeAnalyzer {
    /**
     * @param array $meta
     * @return RouterType
     */
    final public static function analysis(array $meta): RouterType {
        return new RouterType();
    }
}
