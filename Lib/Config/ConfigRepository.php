<?php
/**
 * ConfigRepositoryory.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Config;
use Here\Config\Constant\SysConstant;
use Here\Lib\Config\Parser\ConfigParserInterface;
use Here\Lib\Config\Parser\Json\JsonParser;
use Here\Lib\Config\Parser\Yaml\YamlParser;
use Here\Lib\Stream\IStream\Local\FileReaderStream;
use Here\Lib\Utils\Storage\MemoryStorageTrait;


/**
 * Class ConfigRepository
 * @package Here\Lib\Config
 */
class ConfigRepository {
    /**
     * memory storage mixin
     */
    use MemoryStorageTrait;

    /**
     * @var ConfigParserInterface
     */
    private static $_parser_chain;

    /**
     * @param string $config_path
     * @return ConfigObjectInterface
     */
    final public static function get_config(string $config_path): ConfigObjectInterface {
        $config = self::get_persistent($config_path);
        if ($config instanceof ConfigObject) {
            return $config;
        }

        self::init_parser_chain();

        // read file contents
        $config = self::$_parser_chain->parse(new FileReaderStream(self::search_config($config_path)));
        return $config;
    }

    /**
     * initializing chain of configure parser
     */
    final private static function init_parser_chain(): void {
        if (!self::$_parser_chain) {
            /**
             * @TODO DI and IoC optimize, from config or user control
             */
            self::$_parser_chain = new YamlParser();
            self::$_parser_chain->add_parser(new JsonParser());
        }
    }

    /**
     * @param string $config_path
     * @return string
     */
    final private static function search_config(string $config_path): string {
        if (is_file($config_path)) {
            return $config_path;
        }

        $config_bases = array('Config');
        foreach ($config_bases as $config_base) {
            $current_path = join(SysConstant::PATH_SEPARATOR, array($config_base, $config_path));
            if (is_file($current_path)) {
                return $current_path;
            }
        }
        return $config_path;
    }
}
