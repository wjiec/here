<?php
/**
 * Memcached Adapter
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */


/**
 * Class Here_Cache_Adapter_Memcached
 */
class Here_Cache_Adapter_Memcached extends Here_Cache_Adapter_Base {
    /**
     * connecting to cache server
     */
    protected function _connect() {
        //create Memcached instance
        if ($this->_connection === null) {
            $this->_connection = new Memcached();

            $server = Here_Cache_Helper::get_server();
            $this->_connection->addServer($server['host'], $server['port']);
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
        $value = $this->_connection->get($key);
        return $value === false ? $default : $value;
    }

    /**
     * @param string $key
     * @param string $value
     * @param int $expired
     * @throws Here_Exceptions_CacheError
     */
    protected function _set($key, $value, $expired = 0) {
        $result = $this->_connection->set($key, $value, (($expired === 0) ? $expired : (time() + $expired)));
        if ($result === false) {
            throw new Here_Exceptions_CacheError('Memcached error occurs',
                'Here:Cache:Adapter:Memcached:_set');
        }
    }

    /**
     * @param string $key
     * @param array $array
     * @throws Here_Exceptions_CacheError
     */
    protected function _set_array($key, array $array) {
        $result = $this->_connection->set($key, $array);
        if ($result === false) {
            throw new Here_Exceptions_CacheError('Memcached error occurs',
                'Here:Cache:Adapter:Memcached:_set');
        }
    }
}
