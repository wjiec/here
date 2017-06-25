<?php
/**
 * Here Cache Adapter
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */


/**
 * Class Here_Cache_Adapter_Base
 */
abstract class Here_Cache_Adapter_Base {
    /**
     * connection descriptor
     *
     * @var Memcached|Redis
     */
    protected $_connection;

    /**
     * server address, port, username and password
     *
     * @var array
     */
    protected $_server_information;

    /**
     * Here_Abstracts_CacheAdapter constructor.
     */
    final public function __construct() {
    }

    /**
     * connect to cache server
     */
    abstract protected function _connect();

    /**
     * from cache getting item
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    final public function get($key, $default = null) {
        // connecting to cache server
        $this->_connect();
        // getting value
        return $this->_unserialize_value($this->_get($key, $default));
    }

    /**
     * @param string $key
     * @param null $default
     * @return mixed
     */
    abstract protected function _get($key, $default = null);

    /**
     * set item to cache
     *
     * @param string $key
     * @param mixed $value
     * @param int $expired
     */
    final public function set($key, $value, $expired = 0) {
        // connecting to cache server
        $this->_connect();
        // serialize value
        $value = $this->_serialize_value($value);
        // setting item
        $this->_set($key, $value, $expired > 0 ? $expired : 0);
    }

    /**
     * setting value
     *
     * @param string $key
     * @param string $value
     * @param int $expired
     */
    abstract protected function _set($key, $value, $expired = 0);

    /**
     * getting array object
     *
     * @param string $key
     * @param array $default
     * @return array
     */
    final public function get_array($key, $default = array()) {
        // connecting to cache server
        $this->_connect();
        // getting value
        return $this->_get_array($key, $default);
    }

    /**
     * getting array from cache server
     *
     * @param string $key
     * @param array $default
     * @return mixed
     */
    abstract protected function _get_array($key, $default = array());

    /**
     *setting array to cache
     *
     * @param string $key
     * @param array $array
     * @param int $expired
     */
    final public function set_array($key, array $array, $expired = 0) {
        // connecting to cache server
        $this->_connect();
        // getting value
        return $this->_set_array($key, $array, $expired);
    }

    /**
     * setting array to cache
     *
     * @param string $key
     * @param array $array
     * @param int $expired
     */
    abstract protected function _set_array($key, array $array, $expired = 0);

    /**
     * serialize value
     *
     * @param mixed $value
     * @return string
     */
    private function _serialize_value($value) {
        $serialize_value = new stdClass();
        $serialize_value->value = $value;
        return serialize($serialize_value);
    }

    /**
     * unserialize value
     *
     * @param $serialize_value
     * @return mixed
     */
    private function _unserialize_value($serialize_value) {
        $value_object = unserialize($serialize_value);
        return $value_object->value;
    }
}
