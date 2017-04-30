<?php
/**
 * Here Plugin Base Class
 * 
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */

abstract class Here_Abstracts_Plugin {
    protected $_plugin_name = null;
    protected $_plugin_options = array();

    public function __construct(array $options = array()) {
    }

    public function export_options() {
        return $this->_plugin_options;
    }

    public function widget_name() {
        return $this->_plugin_name;
    }
}