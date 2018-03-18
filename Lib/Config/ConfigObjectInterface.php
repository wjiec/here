<?php
/**
 * ConfigObjectInterface.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Config;


/**
 * Class ConfigObjectInterface
 * @package Lib\Config
 */
interface ConfigObjectInterface {
    /**
     * @param string $key
     * @param null $default
     * @return mixed
     */
    public function get_item(string $key, $default = null);
}
