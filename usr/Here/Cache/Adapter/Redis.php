<?php
/**
 * Redis Cache Server Adapter
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */


/**
 * Class Here_Cache_Adapter_Redis
 */
class Here_Cache_Adapter_Redis extends Here_Cache_Adapter_Base {
    /**
     * connecting to cache server
     */
    protected function _connect() {
        // create Redis instance
        if ($this->_connection === null) {
            $this->_connection = new Redis();
        }

        try {
            if ($this->_connection->ping() !== 'PONG') {
                $server = Here_Cache_Helper::get_server();
                // connecting to cache server
                if ($this->_connection->connect($server['host'], $server['port']) === false) {
                    throw new Here_Exceptions_CacheError($this->_connection->getLastError(),
                        'Here:Cache:Adapter:Redis:_connect');
                }
            }
        } catch (RedisException $e) {
            throw new Here_Exceptions_CacheError($this->_connection->getLastError(),
                'Here:Cache:Adapter:Redis:_connect');
        }
    }

    /**
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    protected function _get($key, $default = null) {
        $value = $this->_connection->get($key);
        return $value === false ? $default : $value;
    }

    /**
     * @param string $key
     * @param array $default
     * @return mixed
     */
    protected function _get_array($key, $default = array()) {
        $array = $this->_connection->lRange($key, 0, -1);
        return $array ?: $default;
    }

    /**
     * @param string $key
     * @param string $value
     * @param int $expired
     * @throws Here_Exceptions_CacheError
     */
    protected function _set($key, $value, $expired = 0) {
        if ($expired === 0) {
            $result = $this->_connection->set($key, $value);
        } else {
            $result = $this->_connection->setex($key, $expired, $value);
        }

        if ($result !== true) {
            throw new Here_Exceptions_CacheError($this->_connection->getLastError(),
                'Here:Cache:Adapter:Redis:_set');
        }
    }

    /**
     * @param string $key
     * @param array $array
     * @throws Here_Exceptions_CacheError
     */
    protected function _set_array($key, array $array) {
        $result = call_user_func_array(
            array($this->_connection, 'rPush'), array_merge(array($key), $array));

        if ($result === false) {
            throw new Here_Exceptions_CacheError($this->_connection->getLastError(),
                'Here:Cache:Adapter:Redis:_set_array');
        }
    }
}
