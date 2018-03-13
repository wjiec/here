<?php
/**
 * ScalarComponent.php
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
 * Class ScalarComponent
 * @package Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\Component
 */
final class ScalarComponent extends ComponentBase implements ScalarComponentInterface {
    /**
     * ScalarComponent constructor.
     * @param Regex $regex
     */
    final public function __construct(Regex $regex) {
        parent::__construct(new ValidUrlType(ValidUrlType::VALID_URL_TYPE_SCALAR_PATH), $regex);
    }
}
