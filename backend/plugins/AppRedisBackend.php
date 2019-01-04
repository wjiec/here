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
use Phalcon\Cache\FrontendInterface;
use \Redis as OriginalRedis;


/**
 * Class RedisPlugin
 * @package Here\plugins
 * @property \Redis $_redis
 * @property FrontendInterface $_frontend
 */
final class AppRedisBackend extends RedisAdapter {

    /**
     * @return OriginalRedis
     */
    final public function getOriginalRedis(): OriginalRedis {
        $this->_connect();
        return $this->_redis;
    }

    /**
     * @param null $keyName
     * @param null $lifetime
     * @return bool
     */
    final public function exists($keyName = null, $lifetime = null) {
        if (!$keyName) {
            return false;
        }

        if (!$this->_redis) {
            $this->_connect();
        }
        return $this->_redis->exists($keyName);
    }

    /**
     * @param string $keyName
     * @param null $lifetime
     * @return mixed|null
     */
    final public function get($keyName, $lifetime = null) {
        if (!$this->_redis) {
            $this->_connect();
        }

        $content = $this->_redis->get($keyName);
        if ($content === false) {
            return null;
        } else if (is_numeric($content)) {
            return $content;
        }
        return $this->_frontend->afterRetrieve($content);
    }

    /**
     * @param null $keyName
     * @param null $content
     * @param null $lifetime
     * @param bool $stopBuffer
     * @return bool
     * @throws \Exception
     */
    final public function save($keyName = null, $content = null, $lifetime = null, $stopBuffer = true) {
        if (!$this->_redis) {
            $this->_connect();
        }

        if (is_callable($content)) {
            $content = $content();
        }
        if (!is_numeric($content)) {
            $content = $this->_frontend->beforeStore($content);
        }

        if ($lifetime === null) {
            $lifetime = $this->_lastLifetime;
            if (!$lifetime) {
                $lifetime = $this->_frontend->getLifetime();
            }
        }

        $status = $this->_redis->set($keyName, $content);
        if (!$status) {
            throw new \Exception("Failed storing the data in redis");
        }

        if ($lifetime >= 1) {
            $this->_redis->setTimeout($keyName, $lifetime);
        }
        return $status;
    }

}
