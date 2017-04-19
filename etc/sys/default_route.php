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
 * Hook check istall
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
     */
    public function entry_point(array $parameters) {
        if (!(is_file(_here_user_configure))) {
            Here_Request::redirection(_here_install_url);
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
    public function urls() {
        return array('/', '/index', '/index.$ext');
    }

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
            Core::router_instance()->error('500', array('error' => 'Missing install file'));
        }
    }
}


/**
 * Route /license
 */
class Route_License extends Here_Abstracts_Route_Route {
    public function urls() {
        return array('/license', '/lincese.$ext');
    }

    public function methods() {
        return array('GET');
    }

    public function hooks() {
        return array();
    }

    public function entry_point(array $parameters) {
        echo '<h1>Blog License</h1>';
        var_dump($parameters);
    }
}


/**
 * Route /recovery
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
 * Route /api
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

// class Route_Static extends Here_Abstracts_Route_Route {
//     public function urls() {
//         return array('/static/...');
//     }

//     public function methods() {
//         return array('GET');
//     }

//     public function hooks() {
//         return array();
//     }

//     public function entry_point(array $parameters) {
//         var_dump($parameters);
//     }
// }