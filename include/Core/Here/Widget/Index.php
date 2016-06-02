<?php
/**
 *
 * @author ShadowMan
 */

class Widget_Index extends Abstract_Widget {
    public function start() {
        // Check Installed
        self::checkInstall();

        // Options Initialize
        Manager_Widget::widget('options')->start();

        $options = Manager_Widget::widget('options');
        Abstract_Widget::options($options);

        // Initialize Plugins
        Manager_Plugin::init();

        // start to indexPage
        Manager_Widget::widget('indexPage@html')->start();
    }

    private function checkInstall() {
        if (!is_file('./config.inc.php')) {
            // install file exists
            if (is_file('admin/install/install.php')) {
                // location
                header('Location: install.php');
            } else {
                Theme::_404('Missing Install File');
            }
        } else if (!@include './config.inc.php') {
            Theme::_404('Error Occurs For Config File');
        }
    }
}

?>