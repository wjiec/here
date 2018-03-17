<?php
/**
 * ComponentBuilder.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\Component;
use Here\Lib\Exceptions\Internal\ImpossibleError;
use Here\Lib\Extension\Regex\Regex;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\ValidUrlType;


/**
 * Class ComponentBuilder
 * @package Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\Component
 */
final class ComponentBuilder {
    /**
     * @param ValidUrlType $type
     * @param array $matches
     * @return ComponentBase
     * @throws ImpossibleError
     */
    final public static function build(ValidUrlType $type, array $matches): ComponentBase {
        switch ($type->value()) {
            case ValidUrlType::VALID_URL_TYPE_SCALAR_PATH:
                return self::build_scalar_component($matches); break;
            case ValidUrlType::VALID_URL_TYPE_VARIABLE_PATH:
                return self::build_variable_complex_component($matches); break;
            case ValidUrlType::VALID_URL_TYPE_OPTIONAL_PATH:
                return self::build_optional_complex_component($matches); break;
            case ValidUrlType::VALID_URL_TYPE_COMPOSITE_VAR_PATH:
                return self::build_variable_composite_component($matches); break;
            case ValidUrlType::VALID_URL_TYPE_COMPOSITE_OPT_PATH:
                return self::build_optional_composite_component($matches); break;
            case ValidUrlType::VALID_URL_TYPE_FULL_MATCHED_PATH:
                return self::build_full_match_component($matches); break;
            default:
                throw new ImpossibleError("Undefined ValidUrlType");
        }
    }

    /**
     * @param array $matches
     * @return ScalarComponent
     */
    final private static function build_scalar_component(array $matches): ScalarComponent {
        return new ScalarComponent(
            new Regex(sprintf('/^%s$/', $matches['scalar']))
        );
    }

    /**
     * @param array $matches
     * @return VariableComplexComponent
     */
    final private static function build_variable_complex_component(array $matches): VariableComplexComponent {
        return new VariableComplexComponent(
            new Regex(sprintf('/^%s$/', $matches['pattern'] ?? '.*')),
            $matches['name'] ?? null
        );
    }

    /**
     * @param array $matches
     * @return OptionalComplexComponent
     */
    final private static function build_optional_complex_component(array $matches): OptionalComplexComponent {
        return new OptionalComplexComponent(
            new Regex(sprintf('/^%s$/', $matches['pattern'] ?? '.*')),
            $matches['name'] ?? null
        );
    }

    /**
     * @param array $matches
     * @return VariableCompositeComponent
     */
    final private static function build_variable_composite_component(array $matches): VariableCompositeComponent {
        return new VariableCompositeComponent(
            $matches['scalar'],
            new Regex(sprintf('/^%s$/', $matches['pattern'] ?? '.*')),
            $matches['name'] ?? null
        );
    }

    /**
     * @param array $matches
     * @return OptionalCompositeComponent
     */
    final private static function build_optional_composite_component(array $matches): OptionalCompositeComponent {
        return new OptionalCompositeComponent(
            $matches['scalar'],
            new Regex(sprintf('/^%s$/', $matches['pattern'] ?? '.*')),
            $matches['name'] ?? null
        );
    }

    /**
     * @param array $matches
     * @return FullMatchComponent
     */
    final private static function build_full_match_component(array $matches): FullMatchComponent {
        return new FullMatchComponent(
            $matches['name'],
            $matches['attributes'] ?? null
        );
    }
}
