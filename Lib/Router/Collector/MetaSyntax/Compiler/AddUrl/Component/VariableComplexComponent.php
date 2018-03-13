<?php
/**
 * VariableComplexComponent.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\Component;
use Here\Lib\Ext\Regex\Regex;
use Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\ValidUrlType;


/**
 * Class VariableComplexComponent
 * @package Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\Component
 */
final class VariableComplexComponent extends ComponentBase implements ComplexComponentInterface {
    /**
     * VariableComplexComponent constructor.
     * @param Regex $regex
     * @param null|string $name
     */
    final public function __construct(Regex $regex, ?string $name = null) {
        parent::__construct(new ValidUrlType(ValidUrlType::VALID_URL_TYPE_COMPOSITE_VAR_PATH), $regex, $name);
    }
}
