<?php
/**
 * Here Themes Helper
 * 
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */

class Theme_Helper extends Here_Abstracts_Widget {

    public function __construct(array $options = array()) {
        parent::__construct($options);
    }

    public static function static_url_completion($path_to_url) {
        echo Here_Request::url_completion($path_to_url);
    }

    public static function include_static_file($static_file_path) {
        
    }
}
