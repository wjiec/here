<?php
/**
 * MemCachedParser.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Cache\Config\Parser;


use Here\Lib\Cache\Adapter\MemCached\MemCachedServerConfig;
use Here\Lib\Cache\Config\CacheServerConfigInterface;
use Here\Lib\Cache\Config\UnknownCacheServerConfig;

/**
 * Class MemCachedParser
 * @package Here\Lib\Cache\Config\Parser
 */
final class MemCachedParser extends CacheConfigParserBase {
    /**
     * @param UnknownCacheServerConfig $config
     * @return CacheServerConfigInterface|null
     */
    protected function parse_config(UnknownCacheServerConfig $config): ?CacheServerConfigInterface {
        if ($config->get_driver() !== 'memcached') {
            return null;
        }
        return MemCachedServerConfig::from($config);
    }
}
