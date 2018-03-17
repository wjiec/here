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
use Here\Lib\Config\Parser\ConfigParserInterface;
use Here\Lib\Config\Parser\Json\JsonParser;
use Here\Lib\Config\Parser\Yaml\YamlParser;
use Here\Lib\Stream\IStream\Local\FileReaderStream;
use Here\Lib\Stream\OStream\Client\Response;
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

        /**
         * @TODO  EmptyConfigObject
         */

        // read file contents
        $config = self::$_parser_chain->parse(new FileReaderStream($config_path));
        return $config;
    }

    /**
     * initializing chain of configure parser
     */
    final private static function init_parser_chain(): void {
        if (!self::$_parser_chain) {
            self::$_parser_chain = new YamlParser();
            self::$_parser_chain->add_parser(new JsonParser());
        }
    }
}
