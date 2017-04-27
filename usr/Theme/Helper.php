<?php
/**
 * Here Themes Helper
 * 
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */


/** Class Theme_Helper
 *
 * One of the most important components, it's Core Widget
 *
 * Mainly used to load a template file, execute utility methods
 */
class Theme_Helper extends Here_Abstracts_Widget {

    /**
     * Theme_Helper constructor.
     *
     * @see Here_Abstracts_Widget::__construct()
     * @param array $options
     */
    public function __construct(array $options = array()) {
        parent::__construct($options);
    }

    /**
     * Static method, incomplete resource file path correction for the complete URL
     *
     * @param string $path_to_url
     */
    public static function static_url_completion($path_to_url) {
        echo Here_Request::url_completion($path_to_url);
    }

    /**
     * include the template file, compiled at the same time
     *
     * @param string $template_file
     * @TODO
     */
    public static function include_template_file($template_file) {
        if (!is_file($template_file)) {

        }
        $template_contents = file_get_contents($template_file);
    }
}
