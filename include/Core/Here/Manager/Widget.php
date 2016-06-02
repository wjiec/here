<?php
/**
 *
 * @author ShadowMan
 */

class Manager_Widget {
    /**
     * Store All Widget Instance
     * 
     * @var unknown
     */
    private static $_widgetPool = array(
        '_global' => array()
    );

    /**
     * 
     */
    public static function widget($alias, $params = array(), $scope = '_global') {
        if (!is_string($alias) || !is_string($scope)) {
            throw new Exception('passing argument 1 of \'alias\' makes string from ' . gettype($alias) . ' without a cast', 1);
        }

        list($alias, $widget) = strpos($alias, '@') ? explode('@', $alias, 2) : array($alias, $alias);
        self::widgetFilter($widget);

        if (array_key_exists($alias, self::$_widgetPool[$scope])) {
            return self::$_widgetPool[$scope][$alias];
        }

        if (class_exists($widget)) {
            if (isset(self::$_widgetPool[$scope])) {
                self::$_widgetPool[$scope] = array();
            }
            return self::$_widgetPool[$scope][$alias] = new $widget($params);
        } else {
            throw new Exception("FATAL ERROR: {$widget} NOT FOUND.", 1);
        }
    }

    private static function widgetFilter(&$widget) {
        return ($widget = 'Widget_' . ucfirst(preg_replace_callback('/\.(\w)?/', function($matches) {
            return '_' . strtoupper(trim($matches[1], '.'));
        }, $widget)));
    }
}

?>