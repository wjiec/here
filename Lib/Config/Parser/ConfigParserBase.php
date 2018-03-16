<?php
/**
 * ConfigParserBase.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Config\Parser;
use Here\Lib\Config\ConfigObject;
use Here\Lib\Stream\IStream\Local\FileReaderStream;
use Here\Lib\Stream\IStream\ReaderStreamInterface;


/**
 * Class ConfigParserBase
 * @package Here\Lib\Config\Parser
 */
abstract class ConfigParserBase implements ConfigParserInterface {
    /**
     * @var ConfigParserInterface
     */
    private $_successor;

    /**
     * @param ConfigParserInterface $parser
     */
    final public function add_parser(ConfigParserInterface $parser): void {
        if ($this->_successor !== null) {
            $this->_successor->add_parser($parser);
        } else {
            $this->_successor = $parser;
        }
    }

    /**
     * @param ReaderStreamInterface $stream
     * @return ConfigObject|null
     */
    final public function parse(ReaderStreamInterface $stream): ?ConfigObject {
        $config = $this->parse_config($stream);
        if ($config instanceof ConfigObject) {
            return $config;
        } else {
            if ($this->_successor === null) {
                return null;
            }
            return $this->_successor->parse($stream);
        }
    }

    /**
     * @param ReaderStreamInterface $stream
     * @return ConfigObject|null
     */
    abstract protected function parse_config(ReaderStreamInterface $stream): ?ConfigObject;
}
