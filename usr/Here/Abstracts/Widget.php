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
     * @access protected
     */
    protected $_widget_name = null;

    /**
     * widget options, default is empty
     *
     * @var array
     * @access protected
     */
    protected $_widget_options = array();

    /**
     * Here_Abstracts_Widget constructor.
     *
     * @param array $options
     */
    public function __construct(array $options = array()) {
        $this->_widget_options = $options;
    }

    /**
     * using for export current widget options
     *
     * @return array
     */
    final public function export_options() {
        return $this->_widget_options;
    }

    /**
     * using for export current widget name
     *
     * @return string
     */
    final public function widget_name() {
        return $this->_widget_name;
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

    /**
     * not allow clone widget, like SingleInstance
     *
     * @throws Exception
     */
    final public function __clone() {
        throw new Exception("Widget '{$this->__toString()}' is single instance", 1996);
    }
}

