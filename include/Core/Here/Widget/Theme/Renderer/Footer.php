<?php
/**
 *
 * @author ShadowMan
 */

class Widget_Theme_Renderer_Footer extends Abstract_Widget {
    /**
     * referer theme information
     * 
     * @var array
     */
    private static $_theme = null;

    public function __construct($file) {
        parent::__construct();

        try {
            $this->_config->file = $this->_findThemeFile($file);
        } catch (Exception $except) {
            throw $except;
        }

        $this->_config->favicon = false;
        $this->_config->stylesheet = array();
        $this->_config->javascript = array();

        return $this;
    }

    public static function init($theme) {
        self::$_theme = $theme;
        self::$_theme['pluginResourceRoot'] = __HERE_PLUGINS_DIRECTORY__;
    }

    public function render() {
        include $this->_config->file;
    }

    public function contents() {
        
    }

    private function _findThemeFile($file) {
        $file = self::$_theme['root'] . '%s%' . '/'
                . ((((strpos($file, '.php') + 4) == strlen($file)) ? $file : ($file . '.php')));

        # Include Customer Theme File
        if (is_file(str_replace('%s%', self::$_theme['name'], $file))) {
            return str_replace('%s%', self::$_theme['name'], $file);
        # Include Default Theme File
        } else if (is_file(str_replace('%s%', self::$_theme['default'], $file))) {
            return str_replace('%s%', self::$_theme['default'], $file);
        # File Not Found
        } else {
            throw new Exception('Cannot include theme file ' . $file, 1);
        }
    }
}

