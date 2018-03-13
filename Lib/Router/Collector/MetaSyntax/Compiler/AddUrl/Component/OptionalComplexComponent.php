<?php
/**
 * OptionalComplexComponent.php
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
 * Class OptionalComplexComponent
 * @package Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\Component
 */
final class OptionalComplexComponent extends ComponentBase implements ComplexComponentInterface {
    /**
     * OptionalComplexComponent constructor.
     * @param Regex $regex
     * @param null|string $name
     */
    final public function __construct(Regex $regex, ?string $name = null) {
        parent::__construct(new ValidUrlType(ValidUrlType::VALID_URL_TYPE_OPTIONAL_PATH), $regex, $name);
    }
}
