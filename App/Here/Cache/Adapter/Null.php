<?php
/**
 * INSERT HERE
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */


/**
 * Class Here_Cache_Adapter_Null
 */
class Here_Cache_Adapter_Null extends Here_Cache_Adapter_Base {
    /**
     * Pretending to connecting to cache server
     */
    protected function _connect() {
        $this->_connection = 'Null';
    }

    /**
     * @param string $key
     * @param null $default
     * @return  null
     */
    protected function _get($key, $default = null) {
        return $default;
    }

    /**
     * @param string $key
     * @param array $default
     * @return array
     */
    protected function _get_array($key, $default = array()) {
        return $default;
    }

    /**
     * @param string $key
     * @param string $value
     * @param int $expired
     */
    protected function _set($key, $value, $expired = 0) {
        // cannot do anything
    }

    /**
     * @param string $key
     * @param array $array
     */
    protected function _set_array($key, array $array) {
        // cannot do anything
    }
}