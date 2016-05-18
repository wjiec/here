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

    private static $_useCommon = null;

    public static function init() {
        if (function_exists('spl_autoload_register')) {
            spl_autoload_register(array('Core', '__autoload'));
        } else {
            function __autoload($class) {
                Core::__autoload($class);
            }
        }

        set_exception_handler(array('Core', 'exceptionHandle'));
        error_reporting(E_ALL);
    }

    public static function exceptionHandle(Exception $except) {
        @ob_end_clean();

        if (in_array($except->getCode(), [ 404, 403, 502 ])){
            // ?
            Theme::{$except->getCode()}($except->getCode(), $except->getMessage());
        } else {
            echo Common::toJSON([
                'code' => $except->getCode(),
                'message' => $except->getMessage()
            ]);
            // TODO Exception
            var_dump(debug_backtrace());
        }
    }

    public static function setRouter(&$router) {
        self::$_router = $router;
    }

    public static function router() {
        if (self::$_router == null) {
            throw new Exception('Router Not Found', 1);
        }
        return self::$_router;
    }

    public static function setUseCommon($useCommon) {
        self::$_useCommon = boolval($useCommon);
    }

    public static function getUseCommon() {
        return self::$_useCommon;
    }

    private static function __autoload( $class ) {
        include_once str_replace(array('\\', '_'), '/', $class) . '.php';
    }
}

?>
