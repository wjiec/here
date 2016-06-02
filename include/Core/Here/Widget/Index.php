<?php
/**
 *
 * @author ShadowMan
 */

class Widget_Init extends Abstract_Widget {
    public function start() {
        // Loading Config
        if (!is_file('./config.inc.php')) {
            if (is_file('admin/install/install.php')) {
                header('Location: install.php');
            } else {
                Theme::_404('Missing Config File');
            }
        } else if (!@include './config.inc.php') {
            Theme::_404('Error Occurs For Config File');
        }

        // Options Initialize
        Manager_Widget::widget('Options')->start();

        Manager_Plugin::init();
    }
}

?>