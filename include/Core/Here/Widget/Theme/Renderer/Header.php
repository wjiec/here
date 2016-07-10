<?php
/**
 *
 * @author ShadowMan
 */


class Widget_Theme_Renderer_Header extends Abstract_Widget {
    /**
     * referer theme information
     * 
     * @var array
     */
    private static $_theme = null;

    /**
     * render text
     * 
     * @var array
     */
    private $_text = null;

    private static $_pluginsResourece = array( 'stylesheet' => array(), 'javascript' => array() );

    public function __construct($file) {
        parent::__construct();

        try {
            $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);

            $this->_config->page = self::_fileFilter($backtrace[1]['file']);
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
            $cssArray[] = self::_FullResourceURI($css, 'css');
        }

        $this->_config->stylesheet = array_filter($cssArray);
        return $this;
    }

    public function javascripts() {
        $jss = func_get_args();
        $jsArray = $this->_config->javascript;

        foreach ($jss as $js) {
            $jsArray[] = self::_FullResourceURI($js, 'js');
        }

        $this->_config->javascript = array_filter($jsArray, function($v) {
            if ($v !== null || !empty($v)) {
                return true;
            }
        });
        return $this;
    }

    /**
     * 
     * 
     * @param array|string $css
     * @param string $pluginRootPath
     * @return boolean
     */
    public static function pluginStylesheet($csss, $plugin, $page) {
        if (!is_array($csss)) {
            return false;
        }

        $tempArray = array();
        foreach ($csss as $css) {
            $tempArray[$page] = self::_FullResourceURI($css, 'css', __HERE_PLUGINS_DIRECTORY__ . _DIRECTORY_SEPARATOR . str_replace('_Plugin', '', $plugin));
        }

        if (!array_key_exists($plugin, self::$_pluginsResourece['stylesheet'])) {
            self::$_pluginsResourece['stylesheet'][$plugin] = array();
        }
        self::$_pluginsResourece['stylesheet'][$plugin] = array_merge(self::$_pluginsResourece['stylesheet'][$plugin], array_filter($tempArray));
        self::$_pluginsResourece['stylesheet'] = array_filter(self::$_pluginsResourece['stylesheet']);

        return true;
    }

    /**
     * 
     * @param array|string $js
     * @param string $pluginRootPath
     */
    public static function pluginJavascript($jss, $plugin, $page) {
        if (!is_array($jss)) {
            return false;
        }

        $tempArray = array();
        foreach ($jss as $js) {
            $tempArray[$page] = self::_FullResourceURI($js, 'js', __HERE_PLUGINS_DIRECTORY__ . _DIRECTORY_SEPARATOR . str_replace('_Plugin', '', $plugin));
        }

        if (!array_key_exists($plugin, self::$_pluginsResourece['javascript'])) {
            self::$_pluginsResourece['javascript'][$plugin] = array();
        }

        self::$_pluginsResourece['javascript'][$plugin] = array_merge(self::$_pluginsResourece['javascript'][$plugin], array_filter($tempArray));
        self::$_pluginsResourece['javascript'] = array_filter(self::$_pluginsResourece['javascript']);
        
        return true;
    }

    public function render() {
        $this->_text = null;

        if ($this->_config->title) {
            $this->_text .= "<title>{$this->_config->title}</title>\n";
        }

        # Favicon Loader
        if ($this->_config->favicon) {
            $this->_text .= "    <link rel=\"shortcut icon\" href=\"/favicon.ico\"/><link rel=\"bookmark\" href=\"/favicon.ico\"/>\n";
        }

        # Stylesheet Setting
        if (!empty($this->_config->stylesheet)) {
            foreach ($this->_config->stylesheet as $css) {
                $this->_text .= "    <link rel=\"stylesheet\" href=\"{$css}\" media=\"all\" />\n";
            }
        }

        if (!empty($this->_config->javascript)) {
            foreach ($this->_config->javascript as $js) {
                $this->_text .= "    <script src=\"{$js}\"></script>\n";
            }
        }

        if (!empty(self::$_pluginsResourece['stylesheet'])) {
            foreach (self::$_pluginsResourece['stylesheet'] as $plugin => $csss) {
                if (array_key_exists($this->_config->page, $csss)) {
                    $this->_text .= "    <link rel=\"stylesheet\" href=\"{$csss[$this->_config->page]}\" media=\"all\" />\n";
                }
            }
        }

        if (!empty(self::$_pluginsResourece['javascript'])) {
            foreach (self::$_pluginsResourece['javascript'] as $plugin => $jss) {
                if (array_key_exists($this->_config->page, $jss)) {
                    $this->_text .= "    <script src=\"{$jss[$this->_config->page]}\"></script>\n";
                }
            }
        }

        include $this->_config->file;
    }

    public function contents() {
        return $this->_text;
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

    private static function _FullResourceURI($module, $ext, $root = null) {
        if ($root === null) {
            $root = self::$_theme['root'];
        } else {
            $root = ltrim($root, '/');
            if (!is_dir($root) || !is_dir($root . _DIRECTORY_SEPARATOR . $ext)) {
                return null;
            } else {
                if (is_file($root . _DIRECTORY_SEPARATOR . $ext . _DIRECTORY_SEPARATOR . $module . '.' . $ext)) {
                    return self::_path2url($root . _DIRECTORY_SEPARATOR . $ext . _DIRECTORY_SEPARATOR . $module . '.' . $ext);
                }
            }
        }

        $file = $root . "%s%" . "/{$ext}/"
            . ((((strpos($module, ".{$ext}") + strlen($ext) + 1) == strlen($module)) ? $module : ($module . ".{$ext}")));

        if (is_file(str_replace('%s%', self::$_theme['name'], $file))) {
            return self::_path2url(str_replace('%s%', self::$_theme['name'], $file));
        } else if (is_file(str_replace('%s%', self::$_theme['default'], $file))) {
            return self::_path2url(str_replace('%s%', self::$_theme['default'], $file));
        } else {
            return null;
        }
    }

    private static function _path2url($fullPath) {
        $fullPath = ltrim($fullPath, '/');
        $fullPath = '/' . $fullPath;

        if (is_file(ltrim($fullPath, '/'))) {
            return Request::getFullUrl($fullPath);
        }
    }

    private static function _fileFilter($path) {
        $path = str_replace('\\', '/', $path);

        return rtrim(substr($path, strrpos($path, '/') + 1), '.php');
    }
}
