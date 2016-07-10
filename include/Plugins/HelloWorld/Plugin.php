<?php
/**
 * Here Plugin Example.
 *  
 * @author   ShadowMan
 * @version  1.0.0
 * @license  MIT License
 * @link     https://github.com/JShadowMan/here
 */

class HelloWorld_Plugin extends Abstract_Plugin {
    public static function activate() {
        return 'HelloWorld';
    }

    public static function resource() {
        Manager_Plugin::registerResocures('index', // page setting
            Manager_Plugin::registerStylesheet('HelloWorld'), // only one file
            Manager_Plugin::registerJavascript('HelloWorld') // too
        );

        Manager_Plugin::registerResocures('admin',
            Manager_Plugin::registerStylesheet('HelloWorld'),
            Manager_Plugin::registerJavascript('HelloWorld')
        );
    }

    public static function render() {
        echo '<div class="hello-world"><p>Hello World</p></div>';
    }
}
