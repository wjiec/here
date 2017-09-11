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
 * @package Here\Lib\Config
 */
class YamlConfig {
    private static $_yaml_version = '1.2';

    /**
     * @param string $version
     * @throws InvalidArgument
     */
    final public static function set_yaml_version($version) {
        if (!in_array($version, array('1.1', '1.2'))) {
            throw new InvalidArgument("Version {$version} of the YAML specifications is not supported");
        }
        self::$_yaml_version = $version;
    }

    /**
     * @return string
     */
    final public static function get_yaml_version() {
        return self::$_yaml_version;
    }

    /**
     * @param string $string
     * @return array
     */
    final public static function load($string) {
        Assert::String($string);

        $parser = new YamlConfigParser(self::$_yaml_version);
        return $parser->parse($string);
    }

    /**
     * @param string $file_path
     * @return array
     */
    final public static function load_file($file_path) {
        Assert::File($file_path);

        $contents = file_get_contents($file_path);
        return self::load($contents);
    }

    /**
     * @param array $object
     * @param int $indent
     * @return string
     */
    final public static function dump(array $object, $indent = 2) {
        $dumper = new YamlConfigDumper(self::$_yaml_version);
        return $dumper->dump($object, $indent);
    }

    /**
     * @param array $object
     * @param int $indent
     * @return bool|int
     */
    final public static function dump_file($filename, array $object, $indent = 2) {
        $dumper = new YamlConfigDumper(self::$_yaml_version);
        $yaml_contents = $dumper->dump($object, $indent);
        return file_put_contents($filename, $yaml_contents);
    }
}
