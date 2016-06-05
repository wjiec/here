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

    private static $_encryptionMode = null;

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
//         @ob_end_clean();

        echo "In {$except->getFile()} At Line {$except->getLine()}<br/>";

        if (in_array($except->getCode(), [ 404, 403, 502 ])){
            $errorCode = ctype_digit($except->getCode()) ? '_' . $except->getCode() : $except->getCode();
            Theme::{$errorCode}($except->getCode(), $except->getMessage());
        } else {
            echo Common::toJSON([
                'code' => $except->getCode(),
                'message' => $except->getMessage()
            ]);
            // TODO Exception
        }
    }

    public static function router() {
        return Widget_Router::export();
    }

    public static function encryptionMode($function) {
        if (function_exists($function) || is_callable($function)) {
            self::$_encryptionMode = $function;
        }
    }

    public static function getEncryptionMode() {
        return self::$_encryptionMode;
    }

    public static function sessionStart() {
        if (session_status() == PHP_SESSION_NONE) {
            return session_start();
        } else {
            return true;
        }
    }

    public static function loadConfig($location = true) {
        if (!is_file('./config.inc.php')) {
            // install file exists
            if ($location && is_file('admin/install/install.php')) {
                // location
                header('Location: install.php');
            } else {
                Theme::_404('Missing Install File');
            }
        } else if (!@include './config.inc.php') {
            Theme::_404('Error Occurs For Config File');
        }
    }

    private static function __autoload( $class ) {
         require_once str_replace(array('\\', '_'), '/', $class) . '.php';
    }
}

?>
