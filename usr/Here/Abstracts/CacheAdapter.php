<?php
/**
 * Cache Abstracts Class
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */


/**
 * Abstract Class:  Here_Abstracts_CacheAdapter
 */
abstract class Here_Abstracts_CacheAdapter {
    /**
     * connection descriptor
     *
     * @var Memcache|Memcached|Redis
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
     *
     * @param string $host
     * @param string|int $port
     * @param string|null $username
     * @param string|null $password
     * @throws Here_Exceptions_CacheError
     */
    public function __construct($host, $port, $username = null, $password = null) {
        // store connect information
        $this->_server_information = func_get_args();

        try {
            // connect to server
            $this->connect();
        } catch (Exception $e) {
            // connecting cache server error
            throw new Here_Exceptions_CacheError("connecting to cache server error occurs.",
                'Here:Abstracts:CacheAdapter:__construct');
        }
    }

    /**
     * connect to cache server
     */
    abstract function connect();

    /**
     * from cache getting item
     *
     * @param string $key
     * @return mixed
     */
    abstract function get($key);

    /**
     * set item to cache
     *
     * @param string $key
     * @param mixed $value
     */
    abstract function set($key, $value);

    /**
     * from cache getting array convert from json data
     *
     * @param $key
     * @return array|null
     */
    final function get_array($key) {
        $value = $this->get($key);

        try {
            return json_decode($value, true);
        } catch (Exception $e) {
            return null;
        }
    }
}