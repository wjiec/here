<?php
/**
 * @author ShadowMan
 * @package Plugin
 */
class Manager_Plugin {
    const PLUGIN_SS_ACTIVE    = 'STATUS_ACTIVE';

    const PLUGIN_SS_DISABLE   = 'STATUS_DISABLE';

    const PLUGIN_HOOKS        = 'HOOKS';

    const PLUGIN_JAVASCRIPT   = 'JAVASCRIPT';

    const PLUGIN_SS_NOT_FOUND = 'STATUS_NOT_FOUND';

    const PLUGIN_STYLE        = 'STYLE';

    const PLUGIN_STATUS       = 'STATUS';

    const PLUGIN_VERSION      = 'VERSION';

    private static $PLUGIN_INFO = 'INFO';

    /**
     * Plugin directory
     * 
     * @var string
     * @access private
     */
    private static $ABSOLUTE_PATH = null;

    /**
     * Plugins list
     * 
     * @var array
     * @access private
     */
    private static $_plugins = array();

    /**
     * activated plugins list
     * 
     * @var array
     */
    private static $_actives = array();

    /**
     * Hooks list
     * 
     * @var array
     */
    private static $_hooks = array();

    // TODO. get activate plugins list from database
    //       merge activate and plugin to activate
    public static function init() {
        if (self::$ABSOLUTE_PATH == null) {
            self::$ABSOLUTE_PATH = __HERE_ROOT_DIRECTORY__ . __HERE_PLUGINS_DIRECTORY__;
        }

        self::collectPlugins();
        self::initActivatePlugins();
        self::initHooks();
    }

    public static function hook($hook) {
        if (($executors = self::executor($hook)) != null) {
            foreach ($executors as $exector) {
                $exector->execute();
            }
        }
    }

    /**
     * bind hook
     * @param string $hook
     * @param array|string $method
     */
    public static function bind($hook, $method) {
        $hook = explode('@', $hook);
        list($module, $position) = (count($hook) == 2) ? $hook : [ null, null ];

        if ($module == null && $position == null) {
            throw new Exception('Params error occurs', 1111);
        }

        if (is_callable($method)) {
            self::$_hooks[$module][$position] = $method;
        }
    }

    /**
     * execute hook or create new hook
     * @param string $hook
     * @return Plugins_Exector
     */
    private static function executor($hook) {
        $hook = explode('@', $hook);
        list($module, $position) = (count($hook) == 2) ? $hook : [ null, null ];

        if ($module == null && $position == null) {
            throw new Exception("Params error occurs.(`{$hook}` NOT FOUND IN " . __FUNCTION__ . ")", 1111);
        }

        if (isset(self::$_hooks[$module][$position])) {
            $exectors = array();
            foreach (self::$_hooks[$module][$position] as $plugin => $method) {
                $exectors[] = Plugins_Exector::factory($module, $position, $method);
            }
            return $exectors;
        } else {
            return null;
        }
    }

    private static function collectPlugins() {
        $directory = dir(self::$ABSOLUTE_PATH);

        while (($entry = $directory->read()) !== false) {
            if ($entry == '.' || $entry == '..') {
                continue;
            }

            if (is_dir(self::$ABSOLUTE_PATH . '/' . $entry) && is_file(self::$ABSOLUTE_PATH . '/' . $entry . '/' . 'Plugin.php')) {
                self::$_plugins[$entry . '_Plugin'] = self::getPluginInfo(self::$ABSOLUTE_PATH . '/' . $entry . '/' . 'Plugin.php');
            }
        }
        $directory->close();
    }

    /**
     * get info from this plugin file
     * 
     * @param string $filename
     * @return array
     */
    private static function getPluginInfo($filename) {
        $content = file_get_contents($filename);
        $plugin  = array();

        $KEY = 1; $VALUE = 2;
        preg_match_all('/^\s*\*\s*\@(author|version|license|link)\s*(.*)$/m', $content, $result);
        for ($length = count($result[$KEY]), $index = 0; $index < $length; ++$index) {
            $plugin[$result[$KEY][$index]] = trim($result[$VALUE][$index]);
        }
        return $plugin;
    }

    private static function initActivatePlugins() {
        $activeDb = new Db();

        $activeDb->query($activeDb->select()->from('table.options')->where('name', Db::OP_EQUAL, 'activePlugins'));
        self::$_actives = unserialize($activeDb->fetchAssoc('value'));

        foreach (self::$_plugins as $plugin => $info) {
            if (array_key_exists($plugin, self::$_actives)) {
                unset(self::$_plugins[$plugin]);
                self::$_actives[$plugin][self::$PLUGIN_INFO] = $info;
            }
        }
    }

    private static function initHooks() {
        $plugins = array_keys(self::$_plugins);
        $hookDb  = new Db();

        $hookDb->query($hookDb->select()->from('table.options')->where('name', Db::OP_EQUAL, 'pluginHooks'));
        self::$_hooks = unserialize($hookDb->fetchAssoc('value'));
    }
}

