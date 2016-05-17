<?php
/**
 *
 * @author ShadowMan
 */
class Widget_Manage {
    /**
     * Widget Manage Factory
     * @param string $widget
     * @return Widget_Abstract|null|mixed
     */
    public static function factory($widget) {
        $widget = (is_string($widget)) ? 'Widget_' . $widget : $widget;

        if (is_object($widget)) {
            return $widget;
        } else if (class_exists($widget)) {
            return $widget::start();
        } else {
            throw new Exception("FATAL ERROR: {$widget} NOT FOUND.", -1);
        }
    }
}

?>