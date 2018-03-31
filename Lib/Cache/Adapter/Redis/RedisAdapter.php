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
