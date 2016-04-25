<?php
/**
 *
 * @author ShadowMan
 */
class Widget_Manage {
    private static $_styles = array();

    private static $_javascripts = array();

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


    public static function load($description) {
        list($resource, $position, $file) = explode('.', $description);

        if ($resource && $position && $file) {
            if ($resource == 'style' || $resource == 'css') {
                $file = "/include/Resource/css/{$position}/{$file}.css";
                if (is_string($file) && is_file(__HERE_ROOT_DIRECTORY__ . $file)) {
                    self::$_styles[] = Request::getFullUrl($file);
                }
            } else if ($resource == 'javascript' || $resource == 'js') {
                $file = "/include/Resource/js/{$position}/{$file}.js";
                if (is_string($file) && is_file(__HERE_ROOT_DIRECTORY__ . $file)) {
                    self::$_javascripts[] = Request::getFullUrl($file);
                }
            } else {
                return;
            }
        }
    }

    public static function style() {
        if (!empty(self::$_styles)) {
            foreach (self::$_styles as $style) {
                echo "    <link rel=\"stylesheet\" href=\"{$style}\" media=\"all\" />\n";
            }
        }
    }

    public static function javascript() {
        if (!empty(self::$_javascripts)) {
            foreach (self::$_javascripts as $javascript) {
                echo "    <script src=\"{$javascript}\"></script>\n";
            }
        }
    }
}

?>