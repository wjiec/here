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
    private static $_widgetPool = array();

    /**
     * 
     */
    public static function widget($alias, $params = array()) {
        list($alias, $widget) = (is_string($alias) && strpos($alias, '@')) ? explode('@', $alias, 2) : array($alias, $alias);
        $widget = 'Widget_' . $widget;

        if (in_array($alias, self::$_widgetPool)) {
            return self::$_widgetPool[$alias];
        }

        if (class_exists($widget)) {
            return self::$_widgetPool[$alias] = new $widget($params);
        } else {
            throw new Exception("FATAL ERROR: {$widget} NOT FOUND.", 1);
        }
    }

}

?>