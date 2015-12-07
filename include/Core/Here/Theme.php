<?php
/**
 * @author ShadowMan
 * @package Theme
 */
class Theme {
    private $_theme = null;
    private $_default = 'default';
    private $_path = 'include/Theme/';
    
    public function __construct($theme = null) {
        if (file_exists($this->_path . $theme) && is_dir($this->_path . $theme)) {
            $this->_theme = $theme;
        }
    }

    public function __call($name, $args) {
        $file = $this->_path . $this->_theme . '/' . trim($name, '_') . '.php';
        if (file_exists($file) && !is_dir($file)) {
            @include $file;
        } else {
            $default = $this->_path . $this->_default . '/' . trim($name, '_') . '.php';
            if (file_exists($default)) {
                @include $default;
            }
        }
    }
}

?>