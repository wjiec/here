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
use Here\Lib\Cache\Adapter\CacheAdapterBase;


/**
 * Class RedisAdapter
 * @package Here\Lib\Cache\Adapter
 */
final class RedisAdapter extends CacheAdapterBase {
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
    final public function destroy_item(string $key): int {
        $this->connect_server();
        return $this->_connection->delete($key);
    }

    /**
     * @param string $key
     * @return bool
     */
    final public function persist_item(string $key): bool {
        $this->connect_server();
        return $this->_connection->persist($key);
    }

    /**
     * @param string $key
     * @return int
     */
    final public function get_ttl(string $key): int {
        $this->connect_server();
        return $this->_connection->ttl($key);
    }

    /**
     * @param string $key
     * @param int $expired
     * @return bool
     */
    final public function set_ttl(string $key, int $expired): bool {
        $this->connect_server();
        return $this->_connection->expire($key, $expired);
    }

    /**
     * @param string $key
     * @param string $value
     * @return bool
     */
    final public function string_item_cache(string $key, string $value): bool {
        return $this->_connection->set($key, $value);
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
