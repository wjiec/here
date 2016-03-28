<?php
/**
 * @author ShadowMan
 * @package Core
 */
class Core {
    const _version = '0.0.1/15.1.1';
    const _MajorVersion = '0.0.1';
    const _MinorVersion = '15.1.1';

    const TOKEN = 'token';

    private static $_router = null;

    public static function init() {
        if (function_exists('spl_autoload_register')) {
            spl_autoload_register(array('Core', '__autoload'));
        } else {
            function __autoload($class) {
                Core::__autoload($class);
            }
        }

        set_exception_handler('Core::exceptionHandle');
        error_reporting(E_ALL);
        header('Content-Type: text/html;charset=UTF-8');
    }

    public static function exceptionHandle(Exception $except) {
        @ob_end_clean();
        Theme::_404($except->getCode(), $except->getMessage());
    }
    
    // TODO: Class<Route> convert to Static Class ?
    public static function setRouter(&$router) {
        self::$_router = $router;
    }
    
    public static function router() {
        if (self::$_router) {
            return self::$_router;
        } else {
            throw new Exception('Fatal Error: Router not set');
        }
    }

    private static function __autoload( $class ) {
        @include_once str_replace(array('\\', '_'), '/', $class) . '.php';
    }
}

?>
