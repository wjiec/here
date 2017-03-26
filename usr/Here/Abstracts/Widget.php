<?php
/**
 * Here Widget Base Class
 * 
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */

abstract class Here_Abstracts_Widget {
    protected $_widget_name = null;
    protected $_widget_options = array();

    public function __construct(array $options = array()) {
        $this->_widget_options = $options;
    }

    public function export_options() {
        return $this->_widget_options;
    }

    public function widget_name() {
        return $this->_widget_name;
    }

    public function __toString() {
        return $this->_widget_name;
    }

    public function __clone() {
        throw new Exception("Widget \'{$this->__toString()}\' is single instance", 1996);
    }
}