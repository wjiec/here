<?php
/**
 * @package Here
 * @author  ShadowMan
 */
class Core {
    const _MajorVersion = '0.0';
    const _MinorVersion = '15.1.1';
    
    public static function init() {
        if (function_exists('spl_autoload_register')) {
            spl_autoload_register(array('Core', '__autoload'));
        } else {
            function __autoload($class) {
                Core::__autoload($class);
            }
        }
    }
    
    private static function __autoload( $class ) {
        @include_once str_replace(array('\\', '_'), '/', $class) . '.php';
    }
}

?>
