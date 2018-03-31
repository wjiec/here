<?php
/**
 * CacheConfigParserBase.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Cache\Config\Parser;
use Here\Lib\Cache\Config\CacheServerConfigInterface;
use Here\Lib\Cache\Config\UnknownCacheServerConfig;


/**
 * @todo merge this and ConfigParser(json, Yaml)
 *
 * Class CacheConfigParserBase
 * @package Here\Lib\Cache\Config\Parser
 */
abstract class CacheConfigParserBase implements CacheConfigParserInterface {
    /**
     * @var CacheConfigParserInterface
     */
    private $_successor;

    /**
     * @param CacheConfigParserInterface $parser
     */
    final public function add_parser(CacheConfigParserInterface $parser): void {
        if ($this->_successor !== null) {
            $this->_successor->add_parser($parser);
        } else {
            $this->_successor = $parser;
        }
    }

    /**
     * @param CacheServerConfigInterface $config
     * @return CacheServerConfigInterface|null
     */
    final public function parse(CacheServerConfigInterface $config): ?CacheServerConfigInterface {
        $cache_server = $this->parse_config($config);
        if ($cache_server instanceof CacheServerConfigInterface) {
            return $cache_server;
        } else {
            if ($this->_successor === null) {
                return null;
            }
            return $this->_successor->parse($config);
        }
    }

    /**
     * @param UnknownCacheServerConfig $config
     * @return CacheServerConfigInterface|null
     */
    abstract protected function parse_config(UnknownCacheServerConfig $config): ?CacheServerConfigInterface;
}
