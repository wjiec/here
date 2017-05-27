<?php
/**
 * Here default router
 * 
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @version   Develop: 0.1.0
 * @link      https://github.com/JShadowMan/here
 */


/**
 * default error handler
 */
Core::router_instance()->default_error(function(array $parameters) {
    // clear ob cache
    ob_clean();
    // report
    echo "<h1>Default Error</h1>";
    var_dump($parameters);
    // back trace
    var_dump(debug_backtrace());
});


/**
 * 404 Not Found
 */
class Error_Not_Found extends Here_Abstracts_Route_Error {
    /**
     * @see Here_Abstracts_Route_Error::errno()
     * @return number
     */
    public function errno() {
        return 404;
    }

    /**
     * @see Here_Abstracts_Route_Error::error()
     * @return string
     */
    public function error() {
        return 'Not Found';
    }

    /**
     * {@inheritDoc}
     * @see Here_Abstracts_Route_Error::entry_point()
     */
    public function entry_point(array $parameters) {
        echo '<h1>Sorry, this page is loss</h1>';
        var_dump($parameters);
    }
}


/**
 * 500 Server Internal Error
 */
class Error_Internal_Error extends Here_Abstracts_Route_Error {
    /**
     * @see Here_Abstracts_Route_Error::errno()
     * @return number
     */
    public function errno() {
        return 500;
    }

    /**
     * @see Here_Abstracts_Route_Error::error()
     * @return string
     */
    public function error() {
        return 'Server Internal Error';
    }

    /**
     * {@inheritDoc}
     * @see Here_Abstracts_Route_Error::entry_point()
     */
    public function entry_point(array $parameters) {
        echo '<h1>500 Server Internal Error</h1>';
        var_dump($parameters);
    }
}


/**
 * Hook authentication
 */
class Hook_Authentication extends Here_Abstracts_Route_Hook {
    /**
     * @see Here_Abstracts_Route_Hook::hook_name
     */
    public function hook_name() {
        return 'authentication';
    }

    /**
     * {@inheritDoc}
     * @see Here_Abstracts_Route_Hook::entry_point()
     */
    public function entry_point(array $parameters) {
        echo '<h1>Check Authentication</h1>';
        var_dump($parameters);

        return true;
    }
}


/**
 * Hook check installer
 */
class Hook_Check_Install extends Here_Abstracts_Route_Hook {
    /**
     * @see Here_Abstracts_Route_Hook::hook_name
     */
    public function hook_name() {
        return 'check_install';
    }

    /**
     * {@inheritDoc}
     * @see Here_Abstracts_Route_Hook::entry_point()
     * @TODO maybe redirect to recovery-guide
     */
    public function entry_point(array $parameters) {
        if (!(is_file(_here_user_configure))) {
            Here_Request::redirection(_here_install_url_);
        }
        return true;
    }
}


/**
 * Route /, /index, /index.$ext
 * 
 * Home page
 */
class Route_Index extends Here_Abstracts_Route_Route {
    /**
     * allow three access methods
     *  * /
     *  * /index
     *  * /index.$ext [/index.html, /index/php, /index.abc, ...]
     *
     * @return array
     */
    public function urls() {
        return array('/', '/index', '/index.$ext');
    }

    /**
     * only allow GET request method
     *
     * @return array
     */
    public function methods() {
        return array('GET');
    }

    /**
     * check blog is installed
     *
     * @return array
     */
    public function hooks() {
        return array('check_install');
    }

    /**
     * entry pointer
     *
     * @param array $parameters
     */
    public function entry_point(array $parameters) {
        echo '<h1>Index Homepage</h1>';
        var_dump($parameters);
    }
}


/**
 * Route /installer-guide
 * 
 * Installer guide page
 */
class Route_Installer extends Here_Abstracts_Route_Route {
    /**
     * installer url
     *
     * @return array
     */
    public function urls() {
        return array(_here_install_url_);
    }

    /**
     * allow 'GET' only
     *
     * @return array
     */
    public function methods() {
        return array('GET');
    }

    /**
     * empty hooks
     *
     * @return array
     */
    public function hooks() {
        return array();
    }

    /**
     * entry pointer
     *
     * @param array $parameters
     */
    public function entry_point(array $parameters) {
        if (is_file(_here_installer_file_)) {
            include _here_installer_file_;
        } else {
            /* magic method: __call, [no qa] */
            Core::router_instance()->emit_error(500, array('error' => 'Missing installer file'));
        }
    }
}


/**
 * Route /license
 */
class Route_License extends Here_Abstracts_Route_Route {
    /**
     * license page url
     *
     * @return array
     */
    public function urls() {
        return array('/license');
    }

    /**
     * allow 'GET' only
     *
     * @return array
     */
    public function methods() {
        return array('GET');
    }

    /**
     * empty hooks
     *
     * @return array
     */
    public function hooks() {
        return array();
    }

    /**
     * entry pointer
     *
     * @param array $parameters
     */
    public function entry_point(array $parameters) {
        echo '<h1 id="title">Blog License</h1>';
        var_dump($parameters);
    }
}


/**
 * Class Route_Recovery
 *
 * Router: /recovery
 */
class Route_Recovery extends Here_Abstracts_Route_Route {
    public function urls() {
        return array(_here_recovery_url_);
    }

    /**
     * allow 'GET' only
     *
     * @return array
     */
    public function methods() {
        return array('GET');
    }

    /**
     * empty hooks
     *
     * @return array
     */
    public function hooks() {
        return array();
    }

    /**
     * entry pointer
     *
     * @param array $parameters
     */
    public function entry_point(array $parameters) {
    
    }
}


/**
 * Class Route_API
 *
 * Router: /api/@v(\d+)@api_version/$module/$operator
 */
class Route_Api extends Here_Abstracts_Route_Route {
    public function urls() {
        return array('/api/@v(\d+)@api_version/$module/$action');
    }

    /**
     * all method allow
     *
     * @return array
     */
    public function methods() {
        return array('ALL');
    }

    /**
     * empty hooks
     *
     * @return array
     */
    public function hooks() {
        return array();
    }

    /**
     * entry pointer
     *
     * @param array $parameters
     * @throws Here_Exceptions_ApiError
     */
    public function entry_point(array $parameters) {
        // from url parameters getting variable
        $module_name = ucfirst($parameters['module']);
        $action_name = $parameters['action'];
        // build api class name
        $api_class_name = "Here_Api_{$module_name}";
        // check class exists
        if (!class_exists($api_class_name)) {
            throw new Here_Exceptions_ApiError("api handler class non exists",
                'Here:Router:api:entry_point');
        }
        // create instance
        $api_instance = new $api_class_name($parameters['re']['api_version']);
        // check action exists
        if (!method_exists($api_class_name, $action_name)) {
            throw new Here_Exceptions_ApiError("action method non exists",
                'Here:Router:api:entry_point');
        }
        // call
        call_user_func(array($api_instance, $action_name), $parameters);
    }
}


/**
 * Class Route_Static
 *
 * Router: /static/???
 */
class Route_Static extends Here_Abstracts_Route_Route {
    public function urls() {
        return array('/static/???');
    }

    /**
     * allow 'GET' only
     *
     * @return array
     */
    public function methods() {
        return array('GET');
    }

    /**
     * empty hooks
     *
     * @return array
     */
    public function hooks() {
        return array();
    }

    /**
     * entry pointer
     *
     * @param array $parameters
     */
    public function entry_point(array $parameters) {
        $static_file = $parameters['full_match_url'];
        $real_file_path = trim(join(_here_path_separator_, array(__HERE_VAR_DIRECTORY__, $static_file)), '/');

        if (is_file($real_file_path)) {
            $explode_array = explode('.', $real_file_path);
            $extension = $explode_array[count($explode_array) - 1];
            Here_Request::set_mime($extension);

            // return resource-file contents
            include $real_file_path;
            // include css/jpg/png/... resource files??? actually works..
            exit;
        } else {
            Here_Request::abort(404, 'Not Found');
        }
    }
}


class Route_Test extends Here_Abstracts_Route_Route {
    public function urls() {
        return array('/test');
    }

    /**
     * allow 'GET' only
     *
     * @return array
     */
    public function methods() {
        return array('ALL');
    }

    /**
     * empty hooks
     *
     * @return array
     */
    public function hooks() {
        return array();
    }

    /**
     * entry pointer
     *
     * @param array $parameters
     */
    public function entry_point(array $parameters) {
        var_dump(Here_Request::path_join(Here_Request::get_url_prefix(), array('abcd', '/abcd', '/abcd/')));
    }
}