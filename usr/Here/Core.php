<?php
/**
 * Here Core Module
 * 
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */

class Core {
    const _major_version = '0.1.0';

    const _minor_version = 'dev-2016-12-22';

    private static $_single_theme_helper_instance = null;

    private static $_single_plugin_helper_instance = null;

    public static function init($debug_mode = false) {
        # register autoload function
        if (function_exists('spl_autoload_register')) {
            spl_autoload_register(array('Core', '__autoload'));
        } else {
            function __autoload($class_name) {
                Core::__autoload($class_name);
            }
        }

        # enable ob cache
        ob_start();

        # error & exception handler
        set_exception_handler(array('Core', '_init_exception_handler'));

        # load sys.conf and definition
        self::load_configure();

        # request module init
        Here_Request::init_request();

        # load base widget
        self::_init_widgets($debug_mode);

        # load helper
        self::_init_helper();

        # init router table
        self::_init_router_table();
    }

    public static function router_instance() {
        return Here_Widget::widget('router')->router_instance();
    }

    // TODO exception_handler
    public static function _init_exception_handler(Exception $exception) {
//         @ob_end_clean();

        echo '<pre>';

        print_r(debug_backtrace());

        echo '</pre>';
    }

    public static function load_configure() {
        # sys definition variable
        require_once 'sys/definition.php';

        # chech here is install or require recovery
        if (is_file(_here_user_configure)) {
            # include user definition variable
            require_once _here_user_configure;
        } else {
            # redirection to install/recovery guide
            if (Here_Widget::widget('router')->current_url() !== _here_install_url) {
                # check request uri is not resource file
                if (!strstr(Here_Widget::widget('router')->current_url(), 'static')) {
                    Here_Widget::widget('router')->redirection(_here_install_url);
                }
            }
        }
    }

    private static function _init_widgets($debug_mode = false) {
        // Widget: Router
        Here_Widget::widget('router');

        // Widget: Interceptor
        Here_Widget::widget('interceptor');

        // Widget: Options
        Here_Widget::widget('options');
    }

    private static function _init_helper() {
        # plugin
        self::$_single_plugin_helper_instance = new Plugins_Helper();

        # theme
        self::$_single_theme_helper_instance = new Theme_Helper();
    }

    private static function _init_router_table() {
        try {
            # system router table
            Here_Widget::widget('router')->import_router_table(_here_sys_default_router_table_);

            # user router table
            Here_Widget::widget('router')->import_router_table(_here_user_router_table_);
        } catch (Exception $e) {
            throw $e;
        }
    }

    private static function __autoload($class_name) {
        require_once str_replace(array('\\', '_'), '/', $class_name) . '.php';
    }
}
