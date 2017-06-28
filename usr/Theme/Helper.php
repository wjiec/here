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
        $this->set_widget_name('Theme Helper');
    }

    /**
     * Static method, incomplete resource file path correction for the complete URL
     *
     * @param string $theme
     * @param string $path
     * @throws Here_Exceptions_ParameterError
     */
    public static function static_completion($theme, $path) {
        // check theme name is correct
        if (!is_string($theme) || strpos($theme, '/') !== false) {
            throw new Here_Exceptions_ParameterError("theme name invalid",
                'Here:Theme:Helper:static_completion');
        }
        $theme = trim($theme, ' /');
        // build theme name
        $theme_path = join('/', array('var', $theme));
        if (!is_string($theme) || strpos($theme, '/') !== false || !is_dir($theme_path)) {
            throw new Here_Exceptions_ParameterError("theme directory not exists",
                'Here:Theme:Helper:static_completion');
        }

        // check path is correct
        Here_Utils::check_type('resource path', $path, 'string',
            'Here:Theme:Helper:static_completion');
        $path = trim($path, ' /');
        // check resource file exists
        $file_path = join('/', array($theme_path, $path));
        if (!is_file($file_path)) {
            throw new Here_Exceptions_ParameterError("resource not exists",
                'Here:Theme:Helper:static_completion');
        }
        // build static url address
        $static_url = join('/', array(rtrim(_here_static_url_prefix_, '/'), $theme, $path));
        echo self::url_completion($static_url);
    }

    /**
     * include the template file, compiled at the same time
     *
     * @param string $template_file
     * @param array $parameters
     * @TODO
     */
    public static function display($template_file, $parameters = null, $force_cache = false) {
        // create template engine
        $engine = new Theme_TemplateEngine_Engine();
    }

    /**
     * url automatic completion
     *
     * @param string $path_to_url
     */
    public static function url_completion($path_to_url) {
        echo Here_Request::url_completion($path_to_url);
    }

    /**
     * get current theme name
     *
     * @return string
     */
    public static function get_theme_name() {
        return Here_Widget::widget('Options')->get_option('theme');
    }

    /**
     * getting blogger title
     *
     * @return string
     */
    public static function get_blogger_title() {
        return Here_Widget::widget('options')->get_option('title');
    }
}
