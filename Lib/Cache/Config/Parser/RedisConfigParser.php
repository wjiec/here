<?php
/**
 * RedisConfigParser.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Cache\Config\Parser;
use Here\Lib\Cache\Adapter\Redis\RedisServerConfig;
use Here\Lib\Cache\Config\CacheServerConfigInterface;
use Here\Lib\Cache\Config\UnknownCacheServerConfig;


/**
 * Class RedisConfigParser
 * @package Here\Lib\Cache\Config\Parser
 */
final class RedisConfigParser extends CacheConfigParserBase {
    /**
     * @param UnknownCacheServerConfig $config
     * @return CacheServerConfigInterface|null
     */
    final protected function parse_config(UnknownCacheServerConfig $config): ?CacheServerConfigInterface {
        if ($config->get_driver() !== 'redis') {
            return null;
        }
        return RedisServerConfig::from($config);
    }
}
