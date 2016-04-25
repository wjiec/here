<?php
/**
 * @author ShadowMan
 * @version 1.0.0
 * @link https://github.com/JShadowMan/here
 * @license MIT License
 */

class HelloWorld_Plugin implements Plugins_Abstract {
    /**
     * when running this plugin activated
     * 
     * @see Plugins_Abstract::activate()
     */
    public static function activate() {
        Plugins_Manage::bind('index@header', array('HelloWorld_Plugin', 'render'));
    }

    public static function render() {
        echo <<<EOF
<div class="widget-hidden"><p>Hello World</p></div>
EOF;
    }
}

?>