<?php
/**
 * CacheConfigGenerator.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Cache\Config\Parser;
use Here\Lib\Cache\Config\CacheServerConfigInterface;
use Here\Lib\Cache\Config\InvalidCacheServerConfig;
use Here\Lib\Cache\Config\UnknownCacheServerConfig;


/**
 * Class CacheConfigGenerator
 * @package Here\Lib\Cache\Parser
 */
final class CacheConfigGenerator {
    /**
     * @param UnknownCacheServerConfig $config
     * @return CacheServerConfigInterface
     * @throws InvalidCacheServerConfig
     */
    final public static function from(UnknownCacheServerConfig $config): CacheServerConfigInterface {
        $parser = new RedisConfigParser();
        $parser->add_parser(new MemCachedParser());

        $cache_server = $parser->parse($config);
        if (!($cache_server instanceof CacheServerConfigInterface)) {
            throw new InvalidCacheServerConfig("invalid cache server config `{$config->get_name()}`");
        }
        return $cache_server;
    }
}
