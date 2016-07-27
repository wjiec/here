<?php
/**
 *
 * @author ShadowMan
 */

class Widget_Init extends Abstract_Widget {
    public function start() {
        // interceptor
        $this->interceptor();

        // if user logined that enable session
        if (Manager_Widget::widget('user')->logined()) {
            session_start();
        }

        // turn on output buffering
        ob_start();

        if (Manager_Widget::widget('flags')->flag('ConfigLoaded')) {
            // alias html.parser to parser
            Manager_Widget::widget('parser@html.parser');

            // alias html.template to template
            Manager_Widget::widget('template@html.template');

            // Initialize Plugins
            Manager_Plugin::init();

            // Theme Helper
            Manager_Widget::widget('helper@theme.helper')->start();
        }
    }

    /**
     * initialize interceptor
     */
    private function interceptor() {
        if (!empty($_GET) || !empty($_POST)) {
            if (empty($_SERVER['HTTP_REFERER'])) {
                exit;
            }

            $parts = parse_url($_SERVER['HTTP_REFERER']);
            if (!empty($parts['port'])) {
                $parts['host'] = "{$parts['host']}:{$parts['port']}";
            }

            if (empty($parts['host']) || $_SERVER['HTTP_HOST'] != $parts['host']) {
                exit;
            }
        }
    }
}
