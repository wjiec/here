<?php
/**
 * Here Widget: CacheManager
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */


/**
 * Class Here_Widget_CacheManager
 */
class Here_Widget_CacheManager extends Here_Abstracts_Widget {
    /**
     * Here_Widget_CacheManager constructor.
     *
     * @param array $options
     */
    public function __construct(array $options = array()) {
        parent::__construct($options);

        $this->_widget_name = 'Cache Manager';
        $this->_options_set('adapter', _here_cache_server_);
    }

    private function _create_cache_instance() {
        // get server name from definitions
        $server_name = $this->_options_get('adapter');
        // check server is available
        $server_state = $this->_check_server_available($server_name);
        if ($server_state === false) {
            $this->_options_set('get', null);
            $this->_options_set('set', null);
        } else if ($server_state == false) {

        }
    }

    private function _check_server_available($server_name) {
        if ($server_name == null) {
            return null;
        }
    }
}
