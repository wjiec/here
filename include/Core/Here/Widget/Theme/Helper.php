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
            'name'  => $this->_options->theme,
            'root'  => 'include/Theme/',
            'default' => 'default',
            'error' => array(
                'template' => 'error.php',
                '404'      => null
            )
        );

        return $this;
    }

    public function required($themeFile) {
        $file  = $this->_theme['root'] . '%s%' . '/'
                . ((strpos($themeFile, '.php')) ? $themeFile : ($themeFile . '.php'));

        # Include Theme File
        if (is_file(str_replace('%s%', $this->_theme['theme'], $file))) {
            include str_replace('%s%', $this->_theme['theme'], $file);
        # Include Default File
        } else if (is_file(str_replace('%s%', $this->_theme['default'], $file))) {
            include str_replace('%s%', $this->_theme['default'], $file);
        } else {
            throw new Exception('Cannot include theme file' . $themeFile, 1);
        }
    }

    public function httpError($code, $params) {
        if (array_key_exists(is_string($code) ? $code : strval($code), $this->_theme['error'])) {
            $params['code'] = intval($code);

            
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