<?php
/**
 * RedisAdapter.php
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Cache\Adapter\Redis;
use Here\Lib\Cache\Adapter\CacheAdapterInterface;
use Here\Lib\Cache\Data\DataType\CacheDataType;


/**
 * Class RedisAdapter
 * @package Here\Lib\Cache\Adapter
 */
final class RedisAdapter implements CacheAdapterInterface {
    /**
     * @var array
     */
    private $_server;

    /**
     * @var \redis
     */
    private $_connection;

    /**
     * RedisAdapter constructor.
     * @param RedisServerConfig $config
     */
    final public function __construct(RedisServerConfig $config) {
        $this->_server = $config;
        $this->_connection = new \redis();

        $this->connect_server();
    }

    /**
     * @param string $key
     * @return int
     */
    final public function typeof(string $key): int {
        $this->connect_server();
        switch ($this->_connection->type($key)) {
            case \redis::REDIS_STRING: return CacheDataType::CACHE_TYPE_STRING;
            case \redis::REDIS_LIST: return CacheDataType::CACHE_TYPE_LIST;
            case \redis::REDIS_HASH: return CacheDataType::CACHE_TYPE_HASH;
            case \redis::REDIS_SET: return CacheDataType::CACHE_TYPE_SET;
            case \redis::REDIS_ZSET: return CacheDataType::CACHE_TYPE_ORDER_SET;
            case \redis::REDIS_NOT_FOUND:
            default: return CacheDataType::CACHE_TYPE_NONE;
        }
    }

    /**
     * @param string $key
     * @return int
     */
    final public function delete_item(string $key): int {
        $this->connect_server();
        return $this->_connection->delete($key);
    }

    /**
     * @param string $key
     * @return bool
     */
    final public function remove_expire(string $key): bool {
        $this->connect_server();
        return $this->_connection->persist($key);
    }

    /**
     * @param string $key
     * @return int
     */
    final public function get_expire(string $key): int {
        $this->connect_server();
        return $this->_connection->ttl($key);
    }

    /**
     * @param string $key
     * @param int $expired
     * @return bool
     */
    final public function set_expire(string $key, int $expired): bool {
        $this->connect_server();
        return $this->_connection->expire($key, $expired);
    }

    /**
     * @param string $key
     * @param string $value
     * @return bool
     */
    final public function string_create(string $key, string $value): bool {
        $this->connect_server();
        return $this->_connection->set($key, $value);
    }

    /**
     * @param string $key
     * @param string $default
     * @return string
     */
    final public function string_get(string $key, string $default): string {
        $this->connect_server();
        return $this->_connection->get($key) ?? $default;
    }

    /**
     * @param string $key
     * @return int
     */
    final public function string_get_length(string $key): int {
        $this->connect_server();
        return $this->_connection->strlen($key);
    }

    /**
     * @param string $key
     * @param string $concat_string
     * @return int
     */
    final public function string_concat(string $key, string $concat_string): int {
        $this->connect_server();
        return $this->_connection->append($key, $concat_string);
    }

    /**
     * 1. check connect available
     * 2. connect to redis when connection invalid
     */
    final private function connect_server(): void {
        try {
            // check connection
            $this->_connection->ping();
        } catch (\Exception $_) {
            // connect to redis server
            $this->_connection->pconnect(
            // host and port
                $this->_server->get_host(), $this->_server->get_port(6379)
            );
        }
    }
}
