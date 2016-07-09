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
        Manager_Plugin::registerResocures('index',
            Manager_Plugin::registerStylesheet('HelloWorld'),
            Manager_Plugin::registerJavascript('HelloWorld')
        );

        Manager_Plugin::registerResocures('admin',
            Manager_Plugin::registerStylesheet('HelloWorld'),
            Manager_Plugin::registerJavascript('HelloWorld')
        );
    }
}
