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
        return array_merge(
            Manager_Plugin::registerStylesheet('HelloWorld', 'Second_Stylesheet'),
            Manager_Plugin::registerJavascript('HelloWorld', 'Second_Javascript')
        );
    }
}

?>