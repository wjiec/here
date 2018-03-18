<?php
/**
 * ConfigParserInterface.php.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Config\Parser;
use Here\Lib\Config\ConfigObject;
use Here\Lib\Stream\IStream\ReaderStreamInterface;


/**
 * Interface ConfigParserInterface
 * @package Lib\Config\Parser
 */
interface ConfigParserInterface {
    /**
     * @param ConfigParserInterface $parser
     */
    public function add_parser(ConfigParserInterface $parser): void;

    /**
     * @param ReaderStreamInterface $stream
     * @return ConfigObject|null
     */
    public function parse(ReaderStreamInterface $stream): ?ConfigObject;

    /**
     * @param ConfigObject $config
     * @return string
     */
    public function dump(ConfigObject $config): string;
}
