<?php
/**
 * ComponentInterface.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\Component;
use Here\Lib\Ext\Regex\Regex;


/**
 * Interface ComponentInterface
 * @package Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\Component
 */
interface ComponentInterface {
    /**
     * @return null|string
     */
    public function get_name(): ?string;

    /**
     * @return Regex
     */
    public function get_regex(): Regex;
}
