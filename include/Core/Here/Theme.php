<?php
/**
 * @author ShadowMan
 * @package Theme
 */
class Theme {
    private $_theme = null;
    const _default_theme_ = 'default';
    const _base_path_ = 'include/Theme/';

    public function __construct($theme = null) {
        if ($theme && file_exists($this->_path . $theme) && is_dir($this->_path . $theme)) {
            $this->_theme = $theme;
        }
    }

    public function __call($name, $args) {
        $_theme_file = Theme::_base_path_ . $this->_theme . '/' . trim($name, '_') . '.php';
        if (file_exists($_theme_file) && !is_dir($_theme_file)) {
            @include $_theme_file;
        } else {
            $_default = Theme::_base_path_ . Theme::_default_theme_ . '/' . trim($name, '_') . '.php';
            if (file_exists($_default)) {
                @include $_default;
            }
        }
    }
}

?>