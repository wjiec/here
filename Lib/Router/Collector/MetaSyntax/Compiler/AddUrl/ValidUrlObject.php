<?php
/**
 * ValidUrlObject.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl;


/**
 * Class ValidUrlObject
 * @package Here\Lib\Router\Collector\MetaSyntax\Compiler\AddUrl
 */
final class ValidUrlObject{
    /**
     * @var array|string[]
     */
    private $_urls;

    /**
     * ValidUrlObject constructor.
     */
    public function __construct() {
        $this->_urls = array();
    }
}
