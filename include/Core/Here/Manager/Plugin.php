<?php
/**
 *
 * @author ShadowMan
 */

if (!defined('__HERE_ROOT_DIRECTORY__')) {
    die('Permission Denied');
}

class Manager_Plugin extends Abstract_Widget {
    /**
     * store all plugins information
     * 
     * @var array
     */
    private static $_plugins = array();

    /**
     * store active plugins
     * 
     * @var array
     */
    private static $_activePlugins = array();

    /**
     * hook list and callback function
     * 
     * @var array
     */
    private static $_hooks = array();

    /**
     * absolute plugins path
     * 
     * @var string
     */
    private static $_absolutePath = null;

    /**
     * temporary hooks, When the administrator activates the plugin to save the hooks
     * 
     * @var array
     */
    private static $_tempHooks = array();

    /**
     * Manager_Plugins Initializer
     */
    public static function init() {
        if (self::$_absolutePath == null) {
            self::$_absolutePath = __HERE_ROOT_DIRECTORY__ . __HERE_PLUGINS_DIRECTORY__;
        }

        # Collect All Plugins
        $directory = dir(self::$_absolutePath);
        while (($entry = $directory->read()) !== false) {
            if ($entry == '.' || $entry == '..') {
                continue;
            }

            if (is_dir(self::$_absolutePath . DIRECTORY_SEPARATOR . $entry) && is_file(self::$_absolutePath . DIRECTORY_SEPARATOR . $entry . DIRECTORY_SEPARATOR . 'Plugin.php')) {
                self::$_plugins[$entry . '_Plugin'] = self::_createPlugin(self::$_absolutePath . DIRECTORY_SEPARATOR . $entry . DIRECTORY_SEPARATOR . 'Plugin.php');
            }
        }

        # From Database Getting Active Plugins & Plugins Information
        self::$_activePlugins = unserialize(Manager_Widget::widget('options')->activePlugins);
        foreach (array_keys(self::$_activePlugins) as $plugin) {
            if (!array_key_exists($plugin, self::$_plugins)) {
                unset($_activePlugins[$plugin]);
                self::$_plugins[$plugin]['valid'] = false;
            }
        }

        # Setting Active Plugins Resource
        foreach (array_keys(self::$_activePlugins) as $plugin) {
            call_user_func(array($plugin, 'resource'));
        }

        self::$_hooks = unserialize(Manager_Widget::widget('options')->pluginHooks);
    }

    /**
     * Execute registered hooks
     * 
     * @param string $hook
     * @param string $default
     * @throws Exception
     */
    public static function hook($hook, $default = null) {
        list($page, $position) = strpos($hook, '@') ? explode('@', $hook) : [ $hook, null ];

        if ($page == null || $position == null || !strlen($page) || !strlen($position)) {
            throw new Exception('Hook Error Occurs, Invalid Hook Name');
        }

        # non hook function
        if (empty(self::$_hooks[$page][$position])) {
            return null;
        } else {
            if (is_callable($default)) {
                call_user_func_array($default, array());
            } else if (is_string($default)) {
                echo htmlentities($default);
            }
        }

        foreach (self::$_hooks[$page][$position] as $plugin => $function) {
            if (is_callable($function)) {
                if (call_user_func_array($function, array()) === false) {
                    throw new Exception("Plugin { {$plugin} } Hook { " . self::_arrayToString($function) . " } Error Occurs.");
                }
            }
        }
    }

    /**
     * bind hook(queue)
     * 
     * @param string $hook
     * @param function $function
     * @throws Exception
     * @return array 
     */
    public static function bind($hook, $function) {
        list($page, $position) = strpos($hook, '@') ? explode('@', $hook) : [ $hook, null ];

        if ($page == null || $position == null || !strlen($page) || !strlen($position)) {
            throw new Exception('Hook Error Occurs, Invalid Hook Name');
        }

        # Create Node
        if (!array_key_exists($page, self::$_tempHooks)) {
            self::$_tempHooks[$page] = array();
        }

        # Create Node
        if (!array_key_exists($position, self::$_tempHooks[$page])) {
            self::$_tempHooks[$position] = array();
        }

        # Save
        if (is_callable($function)) {
            self::$_tempHooks[$page][$position][] = $function;
        }

        return array($hook, $function);
    }

    // TODO. administrator operator
    public static function activate($plugin) {
        
    }

    public static function registerResocures($page/* [, ...] */) {
        $plugin = Common::prevClass();

        $args = func_get_args(); array_shift($args);
        $resource = array();
        foreach ($args as $val) {
            $resource = array_merge($resource, $val);
        }

        if (array_key_exists('stylesheet', $resource)) {
            Widget_Theme_Renderer_Header::pluginStylesheet($resource['stylesheet'], $plugin, $page);
        }

        if (array_key_exists('javascript', $resource)) {
            Widget_Theme_Renderer_Header::pluginJavascript($resource['javascript'], $plugin, $page);
        }
    }

    public static function registerStylesheet() {
        return array('stylesheet' => func_get_args());
    }

    public static function registerJavascript() {
        return array('javascript' => func_get_args());
    }

    private static function _createPlugin($name, $author = null, $version = null, $license = null, $link = null) {
        $information = array();

        if (array_key_exists($name, self::$_plugins)) {
            return null;
        } else {
            $information = array_merge($information, self::_pluginFinder($name));
        }

        return $information;
    }

    private static function _pluginFinder($pluginPath) {
        $plugin  = array();

        if (is_file($pluginPath)) {
            $contents = file_get_contents($pluginPath);

            preg_match_all('/^\s*\*\s*\@(author|version|license|link)\s*(.*)$/m', $contents, $result);
            for ($length = count($result[1]), $index = 0; $index < $length; ++$index) {
                $plugin[$result[1][$index]] = trim($result[2][$index]);
            }
            $plugin['path'] = $pluginPath;
            $plugin['valid'] = true;
        } else if (is_file(self::$_absolutePath . DIRECTORY_SEPARATOR . $pluginPath . DIRECTORY_SEPARATOR . 'Plugin.php')) {
            return self::_pluginFinder(self::$_absolutePath . DIRECTORY_SEPARATOR . $pluginPath . DIRECTORY_SEPARATOR . 'Plugin.php');
        } else {
            return array();
        }

        return $plugin;
    }

    private static function _valueFilter($array) {
        if (!is_array($array)) {
            return array();
        }

        return array_filter(array_map(function($value) {
            if (is_string($value)) {
                return $value;
            } else if (is_array($value)) {
                return self::_valueFilter($value);
            }
        }, $array));
    }

    private static function _arrayToString(array $array) {
        return "array( " . implode(',', $array) . " )";
    }
}
