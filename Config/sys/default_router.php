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
        // report to client
        Here_Response::json_response(array(
            'errno' => $parameters[0],
            'error' => $parameters[1]
        ));
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
        if (!(is_file(_here_user_configure_))) {
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
        // create theme helper
        $helper = new Theme_Helper();
        // display template
        $helper->display('index.tpl', $parameters);
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
        /* @var Here_Widget_Rsa $rsa */
        $rsa = Here_Widget::widget('Rsa');

        $rsa->set_private_key(<<<EOF
-----BEGIN RSA PRIVATE KEY-----
MIICXQIBAAKBgQC3UAPqn9tXL64FV0wSZWV/vCekDGTLpp+dtbL9Bj/hZBh+5AO3
/VvtcQUFck9MD/mU3V2A9IK9gZCMxdLp1tL+wR27OO+bCUuje6QX7tLyyge3x16e
5uKw6TcLU+pj1bJ8Enu4QlDWAtzwR0yZe8C6NnseSHvk+xwVFF4aLvmNAQIDAQAB
AoGAHMYLh1WGSV4rk50LTMvrrawsELz9SVYjMc8mhD7p4ggjLC/AQa4cMt4Nqrgx
qD/Nrkc8+RPoPbTLqr0WiSv2PFA/EMXQz6l6Beg4x7ncQH5ccRD2iEVN+RtB4t6i
btlt53mHUaa5twZf81wmfA9Cr8cbFnJ1UzGpuxav4fNPPEECQQDzOgdusgdqqWoi
N4wBwc+oAlou9o+SXpGAsaN2WvStn7erpqp+d6cWCIEkZxK51ikdW/6i9jCEW793
vZev+8RpAkEAwPB+PR+m7IJV9jyxSd3WvkFng8LjHLdTz983IEvh1Wis37UlTk3B
JtbUaz5QSfLA1Y9enm99l03EN/1XvM2Q2QJBAKcsynD+MnTQbt+H2FZY1RbATyYa
WAIdt9qBvj2aNLSlo8N6cZMtQI23WLQhmFBc77N7SKDPn/dJbGery3etD4kCQH5n
EM2Kxxl76kWATcZPCDltMBwquhA+KzKs0rjd/f6KrXeCfgZm+nwvkssP8BoCaEOB
wkOaV3WhBUSJPcn8A0ECQQCq+YG3H3LnCs4SHGZU9qfr5W+V3II+8mnFXLXWZvEL
M8Sm2zGIKhY/t3yv9EwKxm30AuBVdAKgdzbbvI7M5tfL
-----END RSA PRIVATE KEY-----
EOF
        );

        echo '<pre>';

        $encrypt_pri = $rsa->private_encrypt("你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.asd大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好.asd.qwe.zxc", 'base64');
        $encrypt_pub = $rsa->public_encrypt("你好.我好.大家好.asdas.大家好你好.assdasasd我好.大家好你好.我好.大as好.大家好你qwe.我好.大家好asd你好.我好.大家asda好你好.我好.大家好你好.我好.大家好你好.我好.大家asdqwe好你好.我好.大dkjskjd爱上较大及辣椒款生动化的阿是哦啊哈的你阿什顿 dasjdha s sadh adha sdasdqwe好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大asdsdh山农大好.大家好你好.我好.大家好你好.qwe我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大家好你好.我好.大和圣诞节哈桑肯asd定句asd.qwe.zxc", 'hex');

        $decrypt_public = $rsa->public_decrypt($encrypt_pri);
        $decrypt_private = $rsa->private_decrypt($encrypt_pub, 'hex');

        echo 'Encrypt-Private:' . '<br>' . $encrypt_pri . '<br>';
        echo 'Decrypt-Public:' . '<br>' . $decrypt_public . '<br>';

        echo '<br>';

        echo 'Encrypt-Public:' . '<br>' . $encrypt_pub . '<br>';
        echo 'Decrypt-Private:' . '<br>' . $decrypt_private . '<br>';
    }
}
