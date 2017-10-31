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
use Here\Lib\Env\BooleanString;
use Here\Lib\Env\GlobalEnvironment;
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
     * @throws ExplicitTypeDeclareMissing
     */
    final public static function analysis(string $name, array $meta): RouterType {
        $type = self::_explicit_flag($meta);
        if ($type->value() === RouterType::ROUTER_TYPE_UNKNOWN) {
            if (BooleanString::is_true(GlobalEnvironment::get_user_env('strict_router'))) {
                throw new ExplicitTypeDeclareMissing("'{$name}' missing explicit router-type declare");
            }
        }
        return $type;
    }

    /**
     * @param array $meta
     * @return RouterType
     */
    final private static function _explicit_flag(array $meta): RouterType {
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
