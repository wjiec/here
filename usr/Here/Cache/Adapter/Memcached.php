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
     *
     */
    protected function _connect() {
        // TODO: Implement _connect() method.
    }

    /**
     * @param string $key
     * @param mixed|null $default
     */
    protected function _get($key, $default = null) {
        // TODO: Implement _get() method.
    }

    /**
     * @param string $key
     * @param array $default
     */
    protected function _get_array($key, $default = array()) {
        // TODO: Implement _get_array() method.
    }

    /**
     * @param string $key
     * @param string $value
     * @param int $expired
     */
    protected function _set($key, $value, $expired = 0) {
        // TODO: Implement _set() method.
    }

    /**
     * @param string $key
     * @param array $array
     * @param int $expired
     */
    protected function _set_array($key, array $array, $expired = 0) {
        // TODO: Implement _set_array() method.
    }
}