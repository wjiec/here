<?php
/**
 *
 * @author ShadowMan
 */

class Widget_Theme_Renderer_Header extends Abstract_Widget {
    private $_theme = null;

    private $_text = null;

    public function __construct($file, $theme) {
        parent::__construct();

        try {
            $this->_theme = $theme;
            $this->_config->file = $this->_findThemeFile($file);
        } catch (Exception $except) {
            throw $except;
        }

        $this->_config->favicon = false;
        $this->_config->stylesheet = array();
        $this->_config->javascript = array();

        return $this;
    }

    public function title($title) {
        $this->_config->title = $title;

        return $this;
    }

    public function favicon() {
        if (is_file('favicon.ico')) {
            $this->_config->favicon = true;
        }

        return $this;
    }

    public function stylesheets() {
        $csss = func_get_args();
        $cssArray = $this->_config->stylesheet;

        foreach ($csss as $css) {
            $cssArray[] = $this->_FullResourceURI($css, 'css');
        }

        $this->_config->stylesheet = array_filter($cssArray);
        return $this;
    }

    public function javascripts() {
        $jss = func_get_args();
        $jsArray = $this->_config->javascript;

        foreach ($jss as $js) {
            $jsArray[] = $this->_FullResourceURI($js, 'js');
        }

        $this->_config->javascript = array_filter($jsArray);
        return $this;
    }

    public function render() {
        $this->_text = null;

        if ($this->_config->title) {
            $this->_text .= "<title>{$this->_config->title}</title>\n";
        }

        if ($this->_config->favicon) {
            $this->_text .= "<link rel=\"shortcut icon\" href=\"/favicon.ico\"/><link rel=\"bookmark\" href=\"/favicon.ico\"/>\n";
        }

        if (!empty($this->_config->stylesheet)) {
            foreach ($this->_config->stylesheet as $css) {
                $this->_text .= "<link rel=\"stylesheet\" href=\"{$css}\" media=\"all\" />\n";
            }
        }

        if (!empty($this->_config->javascript)) {
            foreach ($this->_config->javascript as $js) {
                $this->_text .= "<script src=\"{$js}\"></script>\n";
            }
        }

        include $this->_config->file;
    }

    public function contents() {
        return $this->_text;
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

    private function _FullResourceURI($module, $ext) {
        $file = $this->_theme['root'] . "%s%" . "/{$ext}/"
        . ((((strpos($module, ".{$ext}") + strlen($ext) + 1) == strlen($module)) ? $module : ($module . ".{$ext}")));

        if (is_file(str_replace('%s%', $this->_theme['name'], $file))) {
            return $this->_path2url(str_replace('%s%', $this->_theme['name'], $file));
        } else if (is_file(str_replace('%s%', $this->_theme['default'], $file))) {
            return $this->_path2url(str_replace('%s%', $this->_theme['default'], $file));
        } else {
            return null;
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
