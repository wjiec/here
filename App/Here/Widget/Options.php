<?php
/**
 * Here Widget: Options
 * 
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */


/**
 * Class Here_Widget_Options
 */
class Here_Widget_Options extends Here_Abstracts_Widget {
    /**
     * Here_Widget_Options constructor.
     * @param array $options
     */
    public function __construct(array $options) {
        // parent class initializing
        parent::__construct($options);
        // check user configure file exists
        if (!is_file(_here_user_configure_)) {
            return;
        }
        // create database helper
        $helper = new Here_Db_Helper();
        // select all options
        $database_options = $helper->query($helper->select('name', 'value')->from('table.options'));
        // update options
        foreach ($database_options as $database_option) {
            $this->set_option($database_option['name'], $database_option['value']);
        }
    }
}

