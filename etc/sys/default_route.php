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
        echo '<h1>Check Authentiation</h1>';
        var_dump($parameters);

        return true;
    }
}


/**
 * Hook check install
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

    public function hooks() {
        return array('check_install');
    }

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
    public function urls() {
        return array('/installer-guide');
    }

    public function methods() {
        return array('GET');
    }

    public function hooks() {
        return array();
    }

    public function entry_point(array $parameters) {
        if (is_file(_here_install_file_)) {
            include _here_install_file_;
        } else {
            /* magic method: __call, [no qa] */
            Core::router_instance()->error('500', array('error' => 'Missing install file'));
        }
    }
}


/**
 * Route /license
 */
class Route_License extends Here_Abstracts_Route_Route {
    public function urls() {
        return array('/license', '/license.$ext');
    }

    public function methods() {
        return array('GET');
    }

    public function hooks() {
        return array();
    }

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
        return array('/recovery');
    }

    public function methods() {
        return array('GET');
    }

    public function hooks() {
        return array();
    }

    public function entry_point(array $parameters) {
    
    }
}


/**
 * Class Route_API
 *
 * Router: /api/@v(\d+)@api_version/$module/$operator
 */
class Route_API extends Here_Abstracts_Route_Route {
    public function urls() {
        return array('/api/@v(\d+)@api_version/$module/$operator');
    }

    public function methods() {
        return array('GET');
    }

    public function hooks() {
        return array();
    }

    public function entry_point(array $parameters) {
        var_dump($parameters);
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

    public function methods() {
        return array('GET');
    }

    public function hooks() {
        return array();
    }

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


/**
 *
 */
class Route_Test extends Here_Abstracts_Route_Route {
    public function urls() {
        return array('/test-db-helper');
    }

    public function methods() {
        return array('GET');
    }

    public function hooks() {
        return array();
    }

    public function entry_point(array $parameters) {
        // initializing database server
        Here_Db_Helper::init_server('mysql:host=192.168.148.128;port=3306;dbname=here;', 'root', 'root');

        // helper instance
        $helper = new Here_Db_Helper('here_');

        // dump helper
        var_dump($helper);

        // dump SELECT query instance
        var_dump($helper->select(array('uid', 'user_id'), 'name', 'password', array('nickname', 'call'))
            // table name
            ->from('table.users', 'u')
            // order
            ->order('name', Here_Db_Helper::ORDER_DESC)
            // order again
            ->order('call', Here_Db_Helper::ORDER_ASC)
            // where
            ->where((new Here_Db_Expression('uid'))->bigger(5))
            // group
            ->group('user_id')
            // group again
            ->group('password', Here_Db_Helper::ORDER_DESC)
            // join
            ->join(array('table.articles', 'arts'))
            // on
            ->on((new Here_Db_Expression('user_id'))->equal('author_id'))
            // having
            ->having((new Here_Db_Expression('author_id'))->equal(5))
            // limit
            ->limit(5)
            // offset
            ->offset(10)
        );
        // dump query result
        var_dump($helper->query(''));
    }
}