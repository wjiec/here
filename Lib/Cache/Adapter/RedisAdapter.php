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
namespace Here\Lib\Cache\Adapter;
use Here\Lib\Cache\Adapter\Redis\RedisServerConfig;
use Here\Lib\Exceptions\GlobalExceptionHandler;
use Here\Lib\Stream\IStream\Client\Parameters\ParameterOverrideError;


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
     * @param string $name
     * @param null $default
     * @return mixed
     */
    final public function get_item(string $name, $default = null) {
        return null;
    }

    /**
     * @param string $name
     * @param $value
     * @param int $expired
     * @return mixed|void
     */
    final public function set_item(string $name, $value, int $expired = 0) {
        if ($expired === 0) {
            $this->_connection->set($name, $value);
        } else {
            $this->_connection->setex($name, $expired, $value);
        }
    }

    /**
     * connect server and check it
     */
    final private function connect_server(): void {
        // connect to redis server
        $this->_connection->pconnect(
            // host and port
            $this->_server->get_host(), $this->_server->get_port(6379)
        );

        try {
            // check connection
            $this->_connection->ping();
        } catch (\Exception $e) {
            GlobalExceptionHandler::trigger_exception($e);
        }
    }
}
