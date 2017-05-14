<?php
/**
 * Here Db Query
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */


class Here_Cache_Memcache extends Here_Abstracts_CacheAdapter {
    /**
     * Here_Cache_Memcache constructor.
     * @param string $host
     * @param int|string $port
     * @param null $username
     * @param null $password
     */
    public function __construct($host, $port, $username = null, $password = null) {
        parent::__construct($host, $port, $username, $password);
    }

    /**
     * connecting to Memcache Server
     */
    public function connect() {
    }

    public function get($key) {
        // TODO: Implement get() method.
    }

    public function set($key, $value) {
        // TODO: Implement set() method.
    }
}