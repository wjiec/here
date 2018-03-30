<?php
/**
 * CacheManager.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Cache;
use Here\Lib\Cache\Adapter\CacheAdapterInterface;
use Here\Lib\Cache\Adapter\Redis\RedisServerConfig;
use Here\Lib\Cache\Adapter\RedisAdapter;


/**
 * Class CacheManager
 * @package Here\Lib\Cache
 */
final class CacheManager {
    /**
     * @var CacheAdapterInterface
     */
    private $_adapter;

    /**
     * CacheManager constructor.
     * @param CacheServerConfigInterface $config
     */
    final public function __construct(CacheServerConfigInterface $config) {
        switch (true) {
            case ($config instanceof RedisServerConfig):
                $this->_adapter = new RedisAdapter($config); break;
            default:
                /* empty */
        }
    }
}
