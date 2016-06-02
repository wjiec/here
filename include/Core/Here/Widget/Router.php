<?php
/**
 *
 * @author ShadowMan
 */

class Widget_Router extends Abstract_Widget {
    private static $_instance = null;

    private static $_self = null;
    /**
     * Router initialize
     * 
     * @see Abstract_Widget
     */
    public function start() {
        if (self::$_instance instanceof Router) {
            return self::$_instance;
        }

        self::$_self = new Widget_Router();
        self::$_instance = (new Router())
        # Request Error: 404 Not Found
        ->error('404', array(self::$_self, 'error_404'))
        # Request Error: 403 Foribdden
        ->error('403', array(self::$_self, 'error_403'))
        # Hook: Verify User
        ->hook('authorization', array(self::$_self, 'hook_authorization'))
        # Std Router: Index, Homepage
        ->get(array('/', '/index.php', '/index.html'), array(Widget_Router::$_self, 'index'))
        # Std Router: Install, Installer
        ->get('install.php', array(self::$_self, 'install'))
        # Std Router: License Page
        ->get(array('license.html', 'license.php'), array(self::$_self, 'license'))
        # Std Router: Admin Dashboard
        ->get(array('/admin/'), array(self::$_self, 'admin'))
        # API Router: Service
        ->match(array('get', 'post', 'patch', 'put', 'delete'), array('/service/$service/$action', '/service/$service/$action/$value'), array(self::$_self, 'service'))
        # End
        ;
    }

    public static function export() {
        return self::$_instance;
    }

    public function error_404($params, $message = null) {
        Theme::_404($message ? $message : null);
    }

    public function error_403($params, $message = null) {
        Theme::_403($message ? $message : null);
    }

    public function hook_authorization($params) {
        // TODO authorization
    }

    public function index($params) {
        // Widget Initialize
        Manager_Widget::widget('index')->start();
    }

    public function install($params) {
        if (is_file('./config.inc.php') && @include_once './config.inc.php') {
            Theme::_404('1984', 'Permission Denied'); // 0x7C0 :D 403
        } else {
            is_file('admin/install/install.php') ? include 'install/install.php' : print('Missing Install.php File'); exit;
        }
//         if (!@include_once './config.inc.php') {
//             file_exists('admin/install/install.php') ? include 'install/install.php' : print('Missing Config File'); exit;
//         } else {
//             Theme::_404('1984', 'Permission Denied'); // 0x7C0 :D 403
//         }
    }

    public function admin($params) {
        if (!@include_once 'config.inc.php') {
            file_exists('admin/install/install.php') ? header('Location: install.php') : print('Missing Config File'); exit;
        }
        is_file('admin/index.php') ? include 'admin/index.php' : print('FATAL ERROR'); exit;
    }

    public function license($params) {
        Theme::_license();
    }

    public function service($params) {
        try {
            Common::noCache();
            Request::s($params['action'], isset($params['value']) ? $params['value'] : null, Request::REST);
            Service::$params['service']($params['action']);
        } catch (Exception $e) {
            Theme::_404($e->getMessage());
        }
    }
}

?>