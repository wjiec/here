<?php
/**
 *
 * @author ShadowMan
 */

class Widget_Theme_Renderer extends Abstract_Widget {
    private $_theme = null;

    public function constructor($file, $theme) {
        try {
            $this->_theme = $theme;
            $this->_config->file = $this->_required($file);
        } catch (Exception $except) {
            throw $except;
        }

        $this->_config->favicon = false;
        $this->_config->stylesheet = array();
        $this->_config->javascript = array();

        return $this;
    }

    /**
     * Render Function
     * 
     * title tag
     */
    public function title($title) {
        $this->_config->title = is_string($title) ? $title : strval($title);

        return $this;
    }

    public function favicon() {
        if (is_file('favicon.ico')) {
            $this->_config->favicon = true;
        }

        return $this;
    }

    /**
     * Render Function
     * 
     * @param string $module
     */
    public function javascript($module) {
        if (!is_string($module)) {
            return $this;
        }

        $this->_config->javascript = array_merge($this->_config->javascript, array($module));
        return $this;
    }

    /**
     * Render Function
     * 
     * @param string $module
     */
    public function stylesheet($module) {
        if (!is_string($module)) {
            return $this;
        }

        $this->_config->stylesheet = array_merge($this->_config->stylesheet, array($module));
        return $this;
    }

    public function hook($pointer) {
        // hook => function(process)
        // execute hook callback
        // TODO.
    }

    public function render() {
        include $this->_config->file;
    }

    private function _required($file) {
        $file = $this->_theme['root'] . '%s%' . '/'
                . ((((strpos($file, '.php') + 4) == strlen($file)) ? $file : ($file . '.php')));

        # Include Theme File
        if (is_file(str_replace('%s%', $this->_theme['name'], $file))) {
            return str_replace('%s%', $this->_theme['name'], $file);
            # Include Default File
        } else if (is_file(str_replace('%s%', $this->_theme['default'], $file))) {
            return str_replace('%s%', $this->_theme['default'], $file);
            # File Not Found
        } else {
            throw new Exception('Cannot include theme file' . $file, 1);
        }
    }

    private function _resource($module, $ext) {
        $file = $this->_theme['root'] . "%s%" . "/{$ext}/"
        . ((((strpos($module, ".{$ext}") + strlen($ext) + 1) == strlen($module)) ? $module : ($module . ".{$ext}")));

        if (is_file(str_replace('%s%', $this->_theme['name'], $file))) {
            return $this->_path2url(str_replace('%s%', $this->_theme['name'], $file));
        } else if (is_file(str_replace('%s%', $this->_theme['default'], $file))) {
            return $this->_path2url(str_replace('%s%', $this->_theme['default'], $file));
        } else {
            throw new Exception("{$ext} Module File Not Found.");
        }
    }

    private function _path2url($fullPath) {
        $fullPath = ltrim($fullPath, '/');
        $fullPath = '/' . $fullPath;
    
        if (is_file(ltrim($fullPath, '/'))) {
            return Request::getFullUrl($fullPath);
        }
    }
}

?>