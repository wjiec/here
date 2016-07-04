<?php
/**
 *
 * @author ShadowMan
 */

class Widget_Theme_Renderer_Footer extends \Abstract_Widget {

    public function __construct($file, $theme) {
        parent::__construct();

        try {
            $this->_theme = $theme;
            $this->_config->file = $this->_findThemeFile($file);
        } catch (Exception $except) {
            throw $except;
        }

        return $this;
    }

    public function render() {
        include $this->_config->file;
    }

    public function contents() {
        
    }

    private function _findThemeFile($file) {
        $file = $this->_theme['root'] . '%s%' . '/'
                . ((((strpos($file, '.php') + 4) == strlen($file)) ? $file : ($file . '.php')));

        # Include Customer Theme File
        if (is_file(str_replace('%s%', $this->_theme['name'], $file))) {
            return str_replace('%s%', $this->_theme['name'], $file);
        # Include Default Theme File
        } else if (is_file(str_replace('%s%', $this->_theme['default'], $file))) {
            return str_replace('%s%', $this->_theme['default'], $file);
        # File Not Found
        } else {
            throw new Exception('Cannot include theme file' . $file, 1);
        }
    }
    
}

