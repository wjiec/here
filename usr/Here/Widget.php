<?php
/**
 * Here Widget Module
 * 
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */

class Here_Widget {
    /**
     * Widget instance pool
     *
     * @var array
     * @access private
     */
    private static $_widgets_pool = array();

    /**
     * widget alias mapping
     *
     * @var array
     * @TODO
     */
    private static $_widgets_mapping = array();

    /**
     * initializing/getting widget instance
     *
     * @param string $widget_name
     * @param string $alias
     * @param array $init_options
     * @return mixed
     * @throws Exception
     */
    public static function widget($widget_name, $alias = null, array $init_options = array()) {
//        $widget_name = strtolower($widget_name);

        if (strpos('@', $widget_name)) {
            list($alias, $widget_name) = explode('@', $widget_name, 2);
        } else {
            $alias = $widget_name;
        }
        $widget_class_name = self::widget_name_filter($widget_name);

        if (!is_string($alias)) {
            throw new Exception('passing argument 1 of \'alias\' makes string from ' . gettype($alias) . ' without a cast', 1996);
        }

        if (array_key_exists($alias, self::$_widgets_pool)) {
            return self::$_widgets_pool[$alias];
        } else if (class_exists($widget_class_name)) {
            return self::$_widgets_pool[$alias] = new $widget_class_name($init_options);
        } else {
            throw new Exception("Fatal error: Widget '{$widget_name}' not found", 1996);
        }
    }

    private static function widget_name_filter($widget_name) {
        return ('Here_Widget_' . ucfirst(preg_replace_callback('/\.(\w)?/', function($matches) {
            return '_' . strtoupper(trim($matches[1], '.'));
        }, $widget_name)));
    }
}
