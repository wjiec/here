<?php
/**
 * Cache Helper
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */


/**
 * Class Here_Cache_Helper
 */
class Here_Cache_Helper {
    /**
     * @var Here_Cache_Adapter_Memcached|Here_Cache_Adapter_Redis|Here_Cache_Adapter_Null
     */
    private $_cache_adapter;

    /**
     * Here_Cache_Helper constructor.
     */
    public function __construct() {
        switch (_here_cache_server_) {
            case 'memcached': $this->_cache_adapter = new Here_Cache_Adapter_Memcached(); break;
            case 'redis': $this->_cache_adapter = new Here_Cache_Adapter_Redis(); break;
            case 'null':
            default: $this->_cache_adapter = new Here_Cache_Adapter_Null();
        }
    }

    /**
     * @param string $key
     * @param mixed $value
     * @param int $expired
     */
    public function set_item($key, $value, $expired = 0) {
        $this->_cache_adapter->set($key, $value, $expired);
    }

    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get_item($key, $default = null) {
        return $this->_cache_adapter->get($key, $default);
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public function set_array($key, $value) {
        $this->_cache_adapter->set_array($key, $value);
    }

    /**
     * @param string $key
     * @param array $default
     * @return array
     */
    public function get_array($key, $default = array()) {
        return $this->_cache_adapter->get_array($key, $default);
    }

    /**
     * @param string $host
     * @param int $port
     * @param string|null $username
     * @param string|null $password
     */
    final public static function init_server($host, $port, $username = null, $password = null) {
        // initializing server information
        self::$_server = array(
            'host' => Here_Utils::to_string($host),
            'port' => Here_Utils::to_int($port),
            'username' => Here_Utils::to_string($username),
            'password' => Here_Utils::to_string($password)
        );
    }

    /**
     * getting server information
     *
     * @return array
     */
    final static public function get_server() {
        return self::$_server;
    }

    /**
     * @var array
     */
    private static $_server;
}
