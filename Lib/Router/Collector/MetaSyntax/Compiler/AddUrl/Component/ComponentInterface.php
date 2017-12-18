<?php
/**
 * Created by PhpStorm.
 * User: ShadowMan
 * Date: 2017/12/19
 * Time: 22:44
 */
namespace Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\Component;
use Here\Lib\Ext\Regex\Regex;


/**
 * Interface ComponentInterface
 * @package Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl\Component
 */
interface ComponentInterface {
    /**
     * @return string
     */
    public function get_name(): string;

    /**
     * @return Regex
     */
    public function get_regex(): Regex;
}
