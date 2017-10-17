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
class Theme_Helper {
    /**
     * @var string
     */
    private $_theme_name;

    /**
     * @var string
     */
    private $_theme_root;

    /**
     * Theme_Helper constructor.
     *
     * @see Here_Abstracts_Widget::__construct()
     */
    final public function __construct() {
        /* @var Here_Widget_Options $options */
        $options = Here_Widget::widget('Options');
        // initializing theme name
        $this->_theme_name = $options->get_option('theme', 'default');
        // initializing theme root directory
        $theme_path = trim(join('/', array(__HERE_VAR_DIRECTORY__, $this->_theme_name)), '/\\');
        if (strpos($this->_theme_name, '/') !== false || !is_dir($theme_path)) {
            throw new Here_Exceptions_ParameterError("theme directory not exists",
                'Here:Theme:Helper:__construct');
        }
        $this->_theme_root = $theme_path;
    }

    /**
     * include the template file, compiled at the same time
     *
     * @param string $template_file
     * @param array $parameters
     * @param bool $force_cache
     * @throws Here_Exceptions_FatalError
     * @TODO
     */
    public function display($template_file, $parameters = null, $force_cache = false) {
        // fix path
        $template_file = Here_Utils::path_patch($template_file);
        // build template path
        $template_path = $this->_absolute_path($template_file);
        // check file exists
        if (!is_file($template_path)) {
            throw new Here_Exceptions_FatalError('template file not found',
                'Here:Theme:Helper:display');
        }
        // create template engine
        $engine = new Theme_TemplateEngine_Engine($parameters, array(
            'force_cache' => $force_cache
        ));
        // compiler template
        $engine->compile($template_path);
        // display page
        $engine->display();
    }

    /**
     * getting absolute path
     *
     * @param string $file_name
     * @return string
     */
    private function _absolute_path($file_name) {
        return join('/', array(
            __HERE_ROOT_DIRECTORY__,
            $this->_theme_root,
            $file_name
        ));
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
        echo Here_Request::url_completion($static_url);
    }

    /**
     * get current theme name
     *
     * @return string
     */
    public function get_theme_name() {
        return $this->_theme_name;
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
