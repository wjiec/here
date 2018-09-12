<?php
/**
 * RedisPlugin.php
 *
 * @package   here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 */
namespace Here\plugins;


use Phalcon\Cache\Backend\Redis;
use \Redis as OriginalRedis;


/**
 * Class RedisPlugin
 * @package Here\plugins
 */
final class AppRedisBackend extends Redis {

    /**
     * @return OriginalRedis
     */
    final public function getOriginalRedis(): OriginalRedis {
        $this->_connect();
        return $this->_redis;
    }

}
