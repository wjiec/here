<?php
/**
 *
 * @author ShadowMan
 */

class Abstract_Widget implements Interface_Widget {
    protected $_config;

    public function __construct($params = array()) {
        $this->_config = Config::factory($params);
    }

    public function output($key) {
        echo ($this->_config->{$key}) ? $this->_config->{$key} : null;
    }

    /**
     * (non-PHPdoc)
     * 
     * @see Interface_Widget::start()
     *
     */
    public function start() {
        /* noop */
    }
}

?>