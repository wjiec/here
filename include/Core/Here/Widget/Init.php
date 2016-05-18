<?php
/**
 *
 * @author ShadowMan
 */

class Widget_Init extends Widget_Abstract {
    public static function start() {
        Widget_Manage::factory('Router');
    }
}

?>