<?php
/**
 * FullMatchComponentInterface.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\Component;


/**
 * Interface FullMatchComponentInterface
 * @package Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\Component
 */
interface FullMatchComponentInterface extends ComponentInterface {
    /**
     * @return string
     */
    public function get_attributes(): string;
}
