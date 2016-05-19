<?php
/**
 *
 * @author ShadowMan
 */

class Widget_Init extends Abstract_Widget {
    public static function start() {
        Manager_Widget::factory('Router');
    }
}

?>