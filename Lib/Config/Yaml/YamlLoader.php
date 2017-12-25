<?php
/**
 * YamlParser*
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Config\Yaml;
use Here\Lib\Ext\File\FileObject;


/**
 * Trait YamlLoader
 * @package Yaml
 */
trait YamlLoader {
    /**
     * @param string $config
     * @return YamlObject
     */
    final public static function loads(string $config): YamlObject {
    }

    /**
     * @param FileObject $file
     * @return YamlObject
     */
    final public static function load(FileObject $file): YamlObject {
        return self::loads('');
    }
}
