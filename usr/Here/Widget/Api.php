<?php
/**
 * Here Widget: Internal API apply
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */


/**
 * Widget Here_Widget_Api
 */
class Here_Widget_Api extends Here_Abstracts_Widget {
    /**
     * Here_Widget_Api constructor.
     * @param string $api_version
     */
    public function __construct($api_version) {
        parent::__construct($api_version);
        $this->set_widget_name('Internal Api');
    }
}
