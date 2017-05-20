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

        $this->set_widget_name('Cache Manager');
        $this->set_option('adapter', _here_cache_server_);
    }
}
