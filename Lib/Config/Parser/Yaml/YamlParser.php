<?php
/**
 * YamlParser.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Config\Parser\Yaml;
use Here\Lib\Config\ConfigObject;
use Here\Lib\Config\Parser\ConfigParserBase;
use Here\Lib\Stream\IStream\ReaderStreamInterface;


/**
 * Class YamlParser
 * @package Here\Lib\Config\Parser\Yaml
 */
final class YamlParser extends ConfigParserBase {
    /**
     * @param ReaderStreamInterface $stream
     * @return ConfigObject|null
     */
    final protected function parse_config(ReaderStreamInterface $stream): ?ConfigObject {
        // TODO: Implement parse_config() method.
    }
}
