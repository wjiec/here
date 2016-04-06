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

        set_exception_handler('Core::exceptionHandle');
        error_reporting(E_ALL);
    }

    public static function exceptionHandle(Exception $except) {
        @ob_end_clean();

        if (in_array($except->getCode(), [ 404, 403, 502 ])){
            Theme::{$except->getCode()}($except->getCode(), $except->getMessage());
        } else {
            echo Common::toJSON([
                'code' => $except->getCode(),
                'message' => $except->getMessage()
            ]);
            var_dump(debug_backtrace());
        }
    }

    // TODO: Class<Route> convert to Static Class ?
    public static function setRouter(&$router) {
        self::$_router = $router;
    }

    public static function router() {
        if (self::$_router == null) {
            self::routerInit();
        }
        return self::$_router;
    }

    public static function setUseCommon($useCommon) {
        self::$_useCommon = boolval($useCommon);
    }

    public static function getUseCommon() {
        return self::$_useCommon;
    }

    private static function routerInit() {
        self::$_router = (new Router())
        ->error('404', function($params, $message = null) {
            Theme::_404($message ? $message : null);
        })
        ->error('403', function($params, $message = null) {
            Theme::_403($message ? $message : null);
        })
        ->hook('authorization', function($params) {
            // verify
        })
        ->get(['/', '/index.php'], function($params) {
            if (!@include_once './config.inc.php') {
               file_exists('admin/install/install.php') ? header('Location: install.php') : print('Missing Config File'); exit;
            }
            Widget_Manage::factory('index');
        })
        ->get('install.php', function($params) {
            if (!@include_once './config.inc.php') {
                file_exists('admin/install/install.php') ? include 'install/install.php' : print('Missing Config File'); exit;
            } else {
                Theme::_404('1984', 'Permission Denied'); // 0x7C0 :D 403
            }
        })
        ->get('license.html', function($params) {
            Theme::_license();
        })
        ->get('/admin/', function($params) {
            if (!@include_once 'config.inc.php') {
                file_exists('admin/install/install.php') ? header('Location: install.php') : print('Missing Config File'); exit;
            }
            is_file('admin/index.php') ? include 'admin/index.php' : print('FATAL ERROR'); exit;
        }, 'authorization')
        ->match(['get', 'post', 'put', 'patch', 'delete'], ['/service/$service/$action', '/service/$service/$action/$value'], function($params) {
            try {
                Common::noCache();
                Request::s($params['action'], isset($params['value']) ? $params['value'] : null, Request::REST);
                Service::$params['service']($params['action']);
            } catch (Exception $e) {
                Theme::_404($e->getMessage());
            }
        }, 'authorization');
    }

    private static function __autoload( $class ) {
        include_once str_replace(array('\\', '_'), '/', $class) . '.php';
    }
}

?>
