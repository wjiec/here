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
    protected $_options = null;

    /**
     * store theme options
     * 
     * @var array
     */
    protected $_theme = array();

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

        try {
            $this->required('function');
        } catch (Exception $e) {
            ;
        }

        return $this;
    }

    public function required($file) {
        $file = $this->_theme['root'] . '%s%' . '/'
            . ((((strpos($file, '.php') + 4) == strlen($file)) ? $file : ($file . '.php')));

        # Include Theme File
        if (is_file(str_replace('%s%', $this->_theme['name'], $file))) {
            include str_replace('%s%', $this->_theme['name'], $file);
        # Include Default File
        } else if (is_file(str_replace('%s%', $this->_theme['default'], $file))) {
            include str_replace('%s%', $this->_theme['default'], $file);
        # File Not Found
        } else {
            throw new Exception('Cannot include theme file' . $file, 1);
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

    public function path2url($fullPath) {
        $fullPath = ltrim($fullPath, '/');
        $fullPath = '/' . $fullPath;

        if (is_file(ltrim($fullPath, '/'))) {
            return Request::getFullUrl($fullPath);
        }
    }

    public function renderer($file) {
        return new Widget_Theme_Renderer($file, $this->_theme);
    }
}

?>