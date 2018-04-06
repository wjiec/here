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
use Here\Lib\Utils\Toolkit\StringToolkit;


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
     * @var bool
     */
    private $_connected_flag = false;

    /**
     * RedisAdapter constructor.
     * @param RedisServerConfig $config
     */
    final public function __construct(RedisServerConfig $config) {
        $this->_server = $config;
        $this->_connection = new \redis();
        // connecting directly
        $this->connect_server();
    }

    /**
     * @param string $key
     * @return int
     */
    final public function typeof(string $key): int {
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
        return $this->_connection->del($key);
    }

    /**
     * @param string $key
     * @return bool
     */
    final public function remove_expire(string $key): bool {
        return $this->_connection->persist($key);
    }

    /**
     * @param string $key
     * @return int
     */
    final public function get_expire(string $key): int {
        return $this->_connection->ttl($key);
    }

    /**
     * @param string $key
     * @param int $expired
     * @return bool
     */
    final public function set_expire(string $key, int $expired): bool {
        return $this->_connection->expire($key, $expired);
    }

    /**
     * @param string $key
     * @param string $value
     * @return bool
     */
    final public function string_create(string $key, string $value): bool {
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
        return $this->_connection->strlen($key);
    }

    /**
     * @param string $key
     * @param string $concat_string
     * @return int
     */
    final public function string_concat(string $key, string $concat_string): int {
        return $this->_connection->append($key, $concat_string);
    }

    /**
     * @param string $key
     * @return int
     */
    final public function string_increment(string $key): int {
        return $this->_connection->incr($key);
    }

    /**
     * @param string $key
     * @return int
     */
    final public function string_decrement(string $key): int {
        return $this->_connection->decr($key);
    }

    /**
     * @param string $key
     * @return array
     */
    final public function list_get(string $key): array {
        return $this->list_range($key, 0, -1);
    }

    /**
     * @param string $key
     * @return int
     */
    final public function list_get_length(string $key): int {
        return $this->_connection->lLen($key);
    }

    /**
     * @param string $key
     * @param array ...$values
     * @return int
     */
    final public function list_push(string $key, ...$values): int {
        return $this->_connection->rPush($key, ...$values);
    }

    /**
     * @param string $key
     * @param null $default
     * @return mixed
     */
    final public function list_pop(string $key, $default = null) {
        return $this->_connection->rPop($key) ?? $default;
    }

    /**
     * @param string $key
     * @param array ...$values
     * @return int
     */
    final public function list_unshift(string $key, ...$values): int {
        return $this->_connection->lPush($key, ...$values);
    }

    /**
     * @param string $key
     * @param null $default
     * @return mixed
     */
    final public function list_shift(string $key, $default = null) {
        return $this->_connection->lPop($key) ?? $default;
    }

    /**
     * @param string $key
     * @param int $start
     * @param int $end
     * @return array
     */
    final public function list_range(string $key, int $start, int $end): array {
        return $this->_connection->lRange($key, $start, $end);
    }

    /**
     * @param string $key
     * @param int $index
     * @param mixed $new_value
     * @return bool
     */
    final public function list_set_item(string $key, int $index, $new_value): bool {
        return $this->_connection->lSet($key, $index, $new_value);
    }

    /**
     * @param string $key
     * @param int $index
     * @return int
     */
    final public function list_remove_item(string $key, int $index): int {
        $random_value = StringToolkit::format('__%s__', StringToolkit::random_string(16));
        $this->list_set_item($key, $index, $random_value);
        return $this->_connection->lRem($key, $random_value, 1);
    }

    /**
     * 1. check connect available
     * 2. connect to redis when connection invalid
     */
    final private function connect_server(): void {
        // skip ping when connected flag set
        if ($this->_connected_flag) {
            return;
        }

        try {
            // check connection
            $this->_connection->ping();
            // set connected flag
            $this->_connected_flag = true;
        } catch (\Exception $_) {
            // connect to redis server
            $this->_connection->pconnect(
                // host and port
                $this->_server->get_host(), $this->_server->get_port(6379)
            );
        }
    }
}
