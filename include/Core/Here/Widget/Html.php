<?php
/**
 *
 * @author ShadowMan
 */

class Widget_Html extends Abstract_Widget {
    public function start() {
        Manager_Widget::widget('html.header')->start();

        

        Manager_Widget::widget('html.footer')->start();
    }
}

?>