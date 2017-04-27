<?php
/**
 * Here widget:IPNetwork
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */


/** Class Here_Widget_IPNetwork
 *
 * IPNetwork widget
 */
class Here_Widget_IPNetwork extends Here_Abstracts_Widget {
    /**
     * @var array
     * @access private
     */
    private $_ip_address = array();

    /**
     * Here_Widget_IPNetwork constructor.
     *
     * @param array $options
     */
    public function __construct(array $options = array()) {
        parent::__construct($options);

        $this->_widget_name = 'IP Network';
        // add to forbidden list
        foreach ($options as $ip_address) {
            $this->_add_to_forbidden_list($ip_address);
        }
    }

    public function add_new($ip_address) {
        return $this->_add_to_forbidden_list($ip_address);
    }

    public function contains($ip) {
        return false;
    }

    private function _add_to_forbidden_list($ip_address) {

    }
}