<?php
/**
 * YamlConfig.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Config\Yaml;
use Here\Lib\Assert;
use Here\Lib\Exceptions\InvalidArgument;


/**
 * Class YamlConfig
 * @package Yaml
 */
final class YamlConfig {
    /**
     * load YamlObject from yaml configure file
     */
    use YamlLoader;

    /**
     * dump YamlObject to yaml configure file
     */
    use YamlDumper;
}
