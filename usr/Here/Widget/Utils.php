<?php
/**
 * Here Widget: Utils
 * 
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */

class Here_Widget_Utils extends Here_Abstracts_Widget {
    public function __construct(array $options = array()) {
        parent::__construct($options);

        $this->_widget_name = 'Utils';
    }
}
