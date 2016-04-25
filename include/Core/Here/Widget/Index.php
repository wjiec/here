<?php
/**
 *
 * @author ShadowMan
 */
class Widget_Index implements Widget_Abstract {
    public static function start() {
        Widget_Manage::load('style.module.index');
        Widget_Manage::load('javascript.module.index');

            // Common Widget: header
        Widget_Manage::factory('Common_Header');

        // index.php Widget: header
        Widget_Manage::factory('Index_Header');

        // index.php Widget: body
        Widget_Manage::factory('Index_Body');

        // index.php Widget: footer
        Widget_Manage::factory('Index_Footer');

        // Common Widget: footer
        Widget_Manage::factory('Common_Footer');
    }
}

?>