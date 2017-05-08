<?php
/**
 * Here Core Module
 * 
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */


class Core {
    /**
     * Here major version information
     */
    const _major_version = '0.1.0';

    /**
     * Here minor version information
     */
    const _minor_version = 'dev-2016-12-22';

    /**
     * Core module initialize method
     *  * register __autoload
     *  * enable ob_cache
     *  * initialize request object
     *  * load configure or redirect to installer-guide
     *  * initialize base widget
     *      * Request
     *      * Interceptor
     *      * Router
     *      * Options
     *  * initialize helper instance
     *      * Plugins Helper
     *      * Theme Helper
     * * load router tables
     *
     * @param bool $debug_mode
     */
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
        self::_catch_all_exceptions();

        # request module init
        Here_Request::init_request();

        # load sys.conf and definition
        self::load_configure();

        # load base widget
        self::_init_widgets($debug_mode);

        # load helper
        self::_init_helper();

        # init router table
        self::_init_router_table();
    }

    /**
     * getting single Router instance
     *
     * @return Here_Router
     */
    public static function router_instance() {
        if (self::$router_instance == null) {
            self::$router_instance = new Here_Router();
        }

        return self::$router_instance;
    }

    /**
     * exceptions/error handler wrapper function
     */
    private static function _catch_all_exceptions() {
        set_exception_handler(array('Core', '_catch_exception_handler'));
        set_error_handler(array('Core', '_catch_error_handler'));
        register_shutdown_function(array('Core', '_at_exit_handler'));
    }

    /**
     * global exceptions handler
     *
     * @Note that providing an explicit Exception type hint for the ex parameter in
     * your callback will cause issues with the changed exception hierarchy in PHP 7.
     *
     * @param Exception|Throwable|Here_Exceptions_Base $exception
     */
    public static function _catch_exception_handler(/* Exception */ /* Throwable */ $exception) {
        $errno = ($exception instanceof Here_Exceptions_Base) ? $exception->get_code() : $exception->getCode();
        $error = $exception->get_message();
        $error_file = $exception->getFile();
        $error_line = $exception->getLine();
        // retransmission to report handler
        self::_report_all_error($errno, $error, $error_file, $error_line, $exception);
    }

    /**
     * handle errors in a script, Note that it is your responsibility to die() if necessary.
     * If the error-handler function returns, script execution will continue with
     * the next statement after the one that caused an error.
     *
     * @param int $errno
     * @param string $error
     * @param string $error_file
     * @param string $error_line
     */
    public static function _catch_error_handler($errno, $error, $error_file, $error_line) {
        // user error level
        $level = array (
            E_WARNING => ":Warning", // 2
            E_PARSE => ":Parse", // 4
            E_NOTICE => ":Notice", // 8
            E_USER_ERROR => "User:Error", // 256
            E_USER_WARNING => "User:Waring", // 512
            E_USER_NOTICE => "User:Notice", // 1024

        );
        self::_report_all_error($level[$errno], $error, $error_file, $error_line);
        // end script
        exit;
    }

    /**
     * method run at script exit, and catch FATAL error
     */
    public static function _at_exit_handler() {
        $E_FATAL_ERROR = E_CORE_ERROR | E_COMPILE_ERROR | E_RECOVERABLE_ERROR | E_PARSE | /* Fatal Error */1;
        $fatal_error = error_get_last();

        if ($fatal_error && $fatal_error['type'] == $fatal_error['type'] & $E_FATAL_ERROR) {
            // clean "Fatal Error: ..." output
//            ob_clean();
            // key information
            $errno = 'Fatal';
            $error = $fatal_error['message'];
            $error_file = $fatal_error['file'];
            $error_line = $fatal_error['line'];
            // report handler
            self::_report_all_error($errno, $error, $error_file, $error_line);
        }
        // no error exit
    }

    /**
     * display error and push to database
     *
     * @TODO database logging
     *
     * @param string|int $errno
     * @param string $error
     * @param string $error_file
     * @param string $error_line
     * @param mixed $extra_data
     */
    private static function _report_all_error($errno, $error, $error_file, $error_line, $extra_data = null) {
//        @ob_clean();

        echo "<h1>Error/Exception Occurs</h1>";

        echo '<pre>';

        var_dump($errno);

        var_dump($error);

        var_dump($error_file);

        var_dump($error_line);

        var_dump($extra_data);

        echo '</pre>';
    }

    /**
     * load configure or redirect to recovery-guide
     *  * database information
     *  * ...
     *
     * @TODO redirect to recovery/installer guide
     */
    public static function load_configure() {
        # sys definition variables
        require_once 'sys/definition.php';

        # check here is install or require recovery
        if (is_file(_here_user_configure)) {
            # include user definition variable
            require_once _here_user_configure;
        } else {
            # redirection to recovery guide
        }
    }

    /**
     * initializing base widgets
     *
     * @param bool $debug_mode
     */
    private static function _init_widgets($debug_mode = false) {
        // Widget: Interceptor
        Here_Widget::widget('interceptor');

        // Widget: Options
        Here_Widget::widget('options');

        // load debug widget
        if ($debug_mode === true) {
            // @TODO debug widget
        }
    }

    /**
     * initializing Theme/Plugins helper
     */
    private static function _init_helper() {
        # plugin
        self::$_single_plugin_helper_instance = new Plugins_Helper();

        # theme
        self::$_single_theme_helper_instance = new Theme_Helper();
    }

    /**
     * initializing router tables
     *
     * @throws Exception
     */
    private static function _init_router_table() {
        try {
            # parser route classes
            $sys_route = self::_get_route_classes(_here_sys_default_router_table_);
            $user_route = self::_get_route_classes(_here_user_router_table_);

            # system router table
            self::router_instance()->import_router_table($sys_route);

            # user router table
            self::router_instance()->import_router_table($user_route);
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * from router tables getting node
     *
     * @param string $path_to_script
     * @return array
     */
    private static function _get_route_classes($path_to_script) {
        $before_classes = get_declared_classes();
        require_once $path_to_script;
        $after_classes = get_declared_classes();
        $route_classes = array_filter(array_map(function($class_name) {
            # remove all abstracts classes
            if (strpos($class_name, 'Here') === 0) {
                return null;
            } else {
                return $class_name;
            }
        }, array_diff($after_classes, $before_classes)));

        return $route_classes;
    }

    /**
     * __autoload function
     *
     * @param string $class_name
     */
    private static function __autoload($class_name) {
        require_once str_replace(array('\\', '_'), '/', $class_name) . '.php';
    }

    /**
     * Router reference
     *
     * @var Here_Router
     */
    private static $router_instance = null;

    /**
     * theme helper instance
     *
     * @var Theme_Helper
     */
    private static $_single_theme_helper_instance = null;

    /**
     * plugins helper instance
     *
     * @var Plugins_Helper
     */
    private static $_single_plugin_helper_instance = null;
}
