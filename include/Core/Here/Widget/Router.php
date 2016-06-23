<?php
/**
 *
 * @author ShadowMan
 */

class Widget_Router extends Abstract_Widget {
    private static $_instance = null;

    /**
     * Router initialize
     * 
     * @see Abstract_Widget
     */
    public function start() {
        if (self::$_instance instanceof Router) {
            return self::$_instance;
        }

        self::$_instance = (new Router())
        # Request Error: 404 Not Found
        ->error('404', array($this, 'error_404'))
        # Request Error: 403 Foribdden
        ->error('403', array($this, 'error_403'))
        # Hook: Verify User
        ->hook('authorization', array($this, 'hook_authorization'))
        # Std Router: Index, Homepage
        ->get(array('/', '/index.php', '/index.html'), array($this, 'index'))
        # Std Router: Install, Installer
        ->get('install.php', array($this, 'install'))
        # Std Router: License Page
        ->get(array('license.html', 'license.php'), array($this, 'license'))
        # Std Router: Admin Dashboard
        ->get(array('/admin/'), array($this, 'admin'))
        # API Router: Service
        ->match(array('get', 'post', 'patch', 'put', 'delete'), array('/service/$service/$action', '/service/$service/$action/$value'), array($this, 'service'))
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

    # Main Entry
    public function index($params) {
        if (!Manager_Widget::widget('flags')->flag('ConfigLoaded')) {
            $this->redirection('/install.php');
        }

        // inlcude index.php
        Manager_Widget::widget('helper')->required('index.php');
    }

    # Installer Entry
    public function install($params) {
        if (Core::sessionStart() && is_file('./config.inc.php') && @include_once './config.inc.php') {
            Theme::_404('1984', 'Permission Denied'); // 0x7C0 :D 403
        } else {
            is_file('admin/install/install.php') ? include 'install/install.php' : print('Missing Install.php File'); exit;
        }
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
        Common::noCache();
        Request::s($params['action'], isset($params['value']) ? $params['value'] : null, Request::REST);
        Service::$params['service']($params['action']);
    }

    private function redirection($url) {
        Response::header('Location', $url);
    }
}

?>