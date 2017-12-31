<?php
/**
 * RouterTypeAnalyzer.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector\Generator;
use Here\Lib\Router\Collector\RouterType;


/**
 * Class RouterTypeAnalyzer
 * @package Here\Lib\Router\Collector\Generator
 */
final class RouterTypeAnalyzer {
    /**
     * @param string $name
     * @param array $meta
     * @return RouterType
     */
    final public static function analysis(string $name, array $meta): RouterType {
        // allowed `routerChannel`, `routerMiddleware`
        foreach (RouterType::get_constants() as $type_name => $type_value) {
            if (isset($meta[$type_value])) {
                return new RouterType($type_value);
            }
        }
        // default is `ROUTER_TYPE_UNKNOWN`
        return new RouterType(RouterType::ROUTER_TYPE_UNKNOWN);
    }

    /**
     * @TODO router-type validate
     */
}
