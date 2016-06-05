<?php
/**
 *
 * @author ShadowMan
 */

class Widget_Theme_Helper extends Abstract_Widget {
    private static $_options = null;

    public function start() {
        self::$_options = (self::$_options != null) ? self::$_options
            : Manager_Widget::widget('options')->start();

        return $this;
    }

    public function required($themeFile) {
        
    }
}

?>