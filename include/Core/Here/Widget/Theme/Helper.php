<?php
/**
 *
 * @author ShadowMan
 */

class Widget_Theme_Helper extends Abstract_Widget {
    /**
     * store global options
     * 
     * @var Widget_Options
     */
    private $_options = null;

    /**
     * store theme options
     * 
     * @var array
     */
    private $_theme = array();

    public function start() {
        $this->_options = ($this->_options != null) ? self::$_options
            : Manager_Widget::widget('options')->start();

        $this->_theme = array(
            'name' => $this->_options->theme,
            'path' => 'include/Theme/'
        );

        return $this;
    }

    public function required($themeFile) {
        $path = $this->_theme['path'] . $this->_theme['name'] . '/'
                . ((strpos($themeFile, '.php')) ? $themeFile : ($themeFile . '.php'));

        if (is_file($path)) {
            include $path;
        } else {
            throw new Exception('Cannot include theme file' . $themeFile, 1);
        }
    }

    public function options() {
        return $this->_options;
    }

    public function p2u($fullPath, $inTheme = false) {
        $fullPath = ltrim($fullPath, '/');
        $fullPath = '/' . $fullPath;

        if (is_file(ltrim($fullPath, '/'))) {
            echo Request::getFullUrl($fullPath);
        }
    }

    /**
     * @return Widget_Theme_Helper
     */
    public static function self() {
        return Manager_Widget::widget('helper');
    }
}

?>