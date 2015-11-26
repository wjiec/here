<?php
/**
 * @package Here
 * @author  ShadowMan
 */
class Core {
    const _MajorVersion = '0.0.1';
    const _MinorVersion = '15.1.1';
    
    public static function init() {
        if (function_exists('spl_autoload_register')) {
            spl_autoload_register(array('Core', '__autoload'));
        } else {
            function __autoload($class) {
                Core::__autoload($class);
            }
        }
        
        self::Maketoken();
    }
    
    private static function __autoload( $class ) {
        @include_once str_replace(array('\\', '_'), '/', $class) . '.php';
    }
    
    private static function Maketoken() {
        $tokenSet = 'ABDEFGHJKLMNPQRSTVWXYabdefghijkmnpqrstvwxy0123456789!@#$%^&*';
        
        self::_shuffle($tokenSet);
        
        if (!isset($_COOKIE['token'])) {
            setcookie('token', substr($tokenSet, 0, 8));
        }
    }
    
    private static function _shuffle(&$var) {
        if (gettype($var) == 'string') {
            $var = str_shuffle($var);
        } else if (gettype($var) == 'array') {
            $var = shuffle($var);
        } else {
            return $var;
        }
    }
}

?>
