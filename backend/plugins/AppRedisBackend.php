<?php
/**
 * AppRedisBackend.php
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.org>
 * @copyright Copyright (C) 2016-2018 Jayson Wang
 * @license   MIT License
 */
namespace Here\Plugins;


use Phalcon\Cache\Backend\Redis as RedisAdapter;
use \Redis as OriginalRedis;


/**
 * Class RedisPlugin
 * @package Here\plugins
 */
final class AppRedisBackend extends RedisAdapter {

    /**
     * @return OriginalRedis
     */
    final public function getOriginalRedis(): OriginalRedis {
        $this->_connect();
        return $this->_redis;
    }

}
