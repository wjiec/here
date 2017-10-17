<?php
/**
 * Here Widget Base Class
 * 
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */


/** Abstract Class Here_Abstracts_Widget
 *
 * Here Widget Base Class
 */
abstract class Here_Abstracts_Widget {
    /**
     * Current widget name
     *
     * @var string
     * @access private
     */
    private $_widget_name = null;

    /**
     * widget options, default is empty
     *
     * @var array
     * @access private
     */
    private $_widget_options = array();

    /**
     * Here_Abstracts_Widget constructor.
     *
     * @param array $options
     */
    public function __construct(array $options = array()) {
        $this->_widget_options = $options;
    }

    /**
     * setting current widget name
     *
     * @param string $widget_name
     */
    final protected function set_widget_name($widget_name) {
        $this->_widget_name = $widget_name;
    }

    /**
     * using for export current widget name
     *
     * @return string
     */
    final public function get_widget_name() {
        return $this->_widget_name;
    }

    /**
     * set key-value pairs to widgets options
     *
     * @param string $key
     * @param mixed $value
     * @param bool $overwrite
     */
    final protected function set_option($key, $value, $overwrite = false) {
        if (array_key_exists($key, $this->_widget_options)) {
            if ($overwrite == false) {
                return ;
            }
        }
        $this->_widget_options[$key] = $value;
    }

    /**
     * from self widget options getting value
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    final public function get_option($key, $default = null) {
        return array_key_exists($key, $this->_widget_options) ? $this->_widget_options[$key] : $default;
    }

    /**
     * using for export current widget options
     *
     * @return array
     */
    final public function get_widget_options() {
        return $this->_widget_options;
    }

    /**
     * not allow clone widget, like SingleInstance
     *
     * @throws Exception
     */
    final public function __clone() {
        throw new Exception("Widget '{$this->__toString()}' is single instance", 1996);
    }

    /**
     * toString method, wait for batter
     *
     * @return string
     * @TODO
     */
    final public function __toString() {
        return $this->_widget_name;
    }
}

