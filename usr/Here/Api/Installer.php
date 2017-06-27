<?php
/**
 * Here Api Handler
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */


/**
 * ApiHandler: Installer
 */
class Here_Api_Installer extends Here_Abstracts_Api {
    /**
     * Here_Api_Installer constructor.
     * @param $api_version
     */
    public function __construct($api_version) {
        // pre initializing
        $this->_api_name = 'Installer';
        $this->_api_version = 'v1';

        parent::__construct($api_version);
    }

    /**
     * display next step contents
     *
     * @param array $parameters
     */
    public function get_step_info(array $parameters) {
        // build step information by json format
        Here_Response::json_response(array(
            '?sep=detecting-server',
            '?sep=database-configure',
            '?sep=admin-configure',
            '?sep=site-configure',
            '?sep=complete-install'
        ));
    }

    /**
     * check server is available
     *
     * @param array $parameters
     */
    public function get_detect_list(array $parameters) {
        // check installed
        $this->_check_installed();
        // return all check step
        Here_Response::json_response(array(
            'url_prefix' => Here_Request::get_url_prefix(),
            'steps' => array(
                array(
                    'name' => 'Web Server',
                    'address' => $this->api_url_for('check_web_server'),
                    'fail_level' => 'Warning'
                ),
                array(
                    'name' => 'Rewrite Support',
                    'address' => $this->api_url_for('check_rewrite'),
                    'fail_level' => 'Error'
                ),
                array(
                    'name' => 'Python',
                    'address' => $this->api_url_for('check_python_support'),
                    'fail_level' => 'Warning'
                ), array(
                    'name' => 'Write Permissions',
                    'address' => $this->api_url_for('check_write_permissions'),
                    'fail_level' => 'Warning'
                ), array(
                    'name' => 'Database Adapter',
                    'address' => $this->api_url_for('check_database_adapter'),
                    'fail_level' => 'Error'
                )
            )
        ));
    }

    /**
     * from server variables getting web server name
     *
     * @param array $parameters
     */
    public function check_web_server(array $parameters) {
        $this->_make_detect_response(true, Here_Request::get_env('server_software'));
    }

    /**
     * check url rewrite is enable. (will always be true)
     *
     * @param array $parameters
     */
    public function check_rewrite(array $parameters) {
        // check installed
        $this->_check_installed();
        // if current method called, then rewrite is enabled
        $this->_make_detect_response(true, 'Enabled');
    }

    /**
     * check server python support
     *
     * @param array $parameters
     */
    public function check_python_support(array $parameters) {
        // check installed
        $this->_check_installed();
        // make response
        $this->_make_detect_response(false, 'Python Not Found');
    }

    /**
     * /api/v1/installer/check_write_permissions
     *
     * @param array $parameters
     */
    public function check_write_permissions(array $parameters) {
        // check installed
        $this->_check_installed();
        // file_put_contents exists
        $write_function = function_exists('file_put_contents');
        // make response
        $this->_make_detect_response($write_function, $write_function ? 'Enable' : 'Disable');
    }

    /**
     * /api/v1/installer/check_database_adapter
     *
     * @param array $parameters
     */
    public function check_database_adapter(array $parameters) {
        // check installed
        $this->_check_installed();
        // make response
        if (class_exists('PDO')) {
            $this->_make_detect_response(true, 'PDO');
        } else if (class_exists('mysqli')) {
            $this->_make_detect_response(true, 'mysqli');
        } else {
            $this->_make_detect_response(false, 'Adapter Not Found');
        }
    }

    /**
     * database configure entry pointer
     *
     * @param array $parameters
     */
    public function database_configure(array $parameters) {
        try {
            // database server connect info
            $database_info = Here_Request::get_request_contents(true);
            // init database helper
            Here_Db_Helper::init_server(Here_Db_Helper::array_to_dsn($database_info),
                $database_info['username'], $database_info['password']);
            // create helper instance
            $helper = new Here_Db_Helper($database_info['table_prefix']);
            /* @var Here_Widget_Jwt $jwt */
            $jwt = Here_Widget::widget('Jwt');
            // connecting to server and get server|client information
            Here_Response::json_response(array_merge($helper->get_adapter_info(), array(
                'token' => $jwt->generate_token($database_info, _here_default_jwt_key_)
            )));
        } catch (Here_Exceptions_ConnectingError $e) {
            // connecting error occurs, connecting error may be encoding error
            Here_Request::abort(500, Here_Response::_Text($e->get_message()));
        }
    }

    /**
     * administrator account configure
     *
     * @param array $parameters
     */
    public function account_configure(array $parameters) {
        // get username/password from request contents
        $account_info = Here_Request::get_request_contents(true);
        /* @var Here_Widget_Jwt $jwt */
        $jwt = Here_Widget::widget('Jwt');
        // make response
        Here_Response::json_response(array(
            'status' => 0,
            'message' => 'success',
            'token' => $jwt->generate_token($account_info, _here_default_jwt_key_)
        ));
    }

    /**
     * blogger information configure
     *
     * @param array $parameters
     */
    public function blogger_configure(array $parameters) {
        // get title/... from request contents
        $blogger_info = Here_Request::get_request_contents(true);
        /* @var Here_Widget_Jwt $jwt */
        $jwt = Here_Widget::widget('Jwt');
        // make response
        Here_Response::json_response(array(
            'status' => 0,
            'message' => 'success',
            'token' => $jwt->generate_token($blogger_info, _here_default_jwt_key_)
        ));
    }

    /**
     * complete installer guide
     *
     * @param array $parameters
     */
    pubLic function complete_install(array $parameters) {
        try {
            // get configure for database, account, blogger
            $configures = Here_Request::get_request_contents(true);
            /* @var Here_Widget_Jwt $jwt */
            $jwt = Here_Widget::widget('Jwt');
            // jwt decode
            foreach ($configures as $key => &$configure) {
                $configure = $jwt->token_decode($configure, _here_default_jwt_key_);
            }
            // create database
            $this->_init_database($configures['database']);
            // create database helper
            $helper = new Here_Db_Helper($configures['database']['table_prefix']);
            // create account
            $this->_init_account($configures['account'], $helper);
            // blogger info
            $this->_init_blogger($configures['blogger'], $helper);
            // create configure file
            $this->_create_configure_file($configures);
            // make response
            Here_Response::json_response(array(
                'status' => 0,
                'message' => 'Here Install Complete'
            ));
        } catch (Here_Exceptions_Base $e) {
            Here_Response::json_response(array(
                'status' => 1,
                'error_step' => $e->get_code(),
                'message' => $e->get_message()
            ));
        }
    }

    /**
     * initializing database
     *
     * @param $configure
     * @throws Here_Exceptions_FatalError
     */
    private function _init_database(array $configure) {
        try {
            // init database helper
            Here_Db_Helper::init_server(Here_Db_Helper::array_to_dsn($configure),
                $configure['username'], $configure['password']);
            // create helper instance
            $helper = new Here_Db_Helper($configure['table_prefix']);
            // reading scripts
            $scripts = file_get_contents('scripts/installer.sql', true);
            // check read complete
            if (!$scripts || !is_string($scripts)) {
                throw new Here_Exceptions_FatalError('cannot reading sql scripts',
                    'Here:Api:Installer:_init_database:reading_scripts');
            }
            // explode segments
            $tables = explode(';', $scripts);
            // create tables
            foreach ($tables as $table_script) {
                $helper->query($table_script . ';');
            }
        } catch (Here_Exceptions_ConnectingError $e) {
            // connecting error occurs, connecting error may be encoding error
            throw new Here_Exceptions_FatalError(Here_Response::_Text($e->get_message()),
                'Here:Api:Installer:_init_database:connecting');
        } catch (Here_Exceptions_QueryError $e) {
            $message = Here_Response::_Text($e->get_message());
            if (strpos($message, 'Duplicate key name') === false) {
                throw new Here_Exceptions_FatalError($message,
                    'Here:Api:Installer:_init_database:query_scripts');
            }
        }
    }

    /**
     * insert admin account to databases
     *
     * @param array $configure
     * @param Here_Db_Helper $helper
     * @throws Here_Exceptions_FatalError
     */
    private function _init_account(array $configure, $helper) {
        try {
            $helper->query($helper->insert()->into('table.users')->one_row(array(
                'name' => $configure['username'],
                'password' => Here_Utils::account_password_encrypt($configure['password']),
                'email' => $configure['email'],
                'created' => time(),
                'last_login' => time()
            )));
        } catch (Here_Exceptions_QueryError $e) {
            throw new Here_Exceptions_FatalError(Here_Response::_Text($e->get_message()),
                'Here:Api:Installer:_init_account:create_account');
        }
    }

    /**
     * insert default data to database
     *
     * @param array $configure
     * @param Here_Db_Helper $helper
     * @throws Here_Exceptions_FatalError
     */
    private function _init_blogger(array $configure, $helper) {
        try {
            // default options
            $helper->query($helper->insert()->into('table.options')
                ->keys('name', 'value')
                ->values('theme', 'default')
                ->values('title', $configure['title'])
                ->values('page_size', 16)
            );
            // example article
            $helper->query($helper->insert()->into('table.articles')->one_row(array(
                'title' => 'Welcome to Here blogger',
                'url' => 'welcome-to-here-blogger',
                'author_id' => 1,
                'created' => time(),
                'last_modify' => time(),
                'contents' => 'This blogger is open in xx/xx/xxxx, hello, everyone~',
                'comments_cnt' => 3,
            )));
            // article comments
            $helper->query($helper->insert()->into('table.comments')
                ->keys('aid', 'author', 'created', 'content')
                ->values(1, 'Som body', time(), 'Hello, everyone')
                ->values(1, 'Anonymous', time(), 'Hum, I\'m going to be hacked this blogger')
                ->values(1, 'Police', time(), 'I got it')
            );
        } catch (Here_Exceptions_QueryError $e) {
            throw new Here_Exceptions_FatalError(Here_Response::_Text($e->get_message()),
                'Here:Api:Installer:_init_account:create_account');
        }
    }

    /**
     * create configure file from template file
     *
     * @param array $configure
     */
    private function _create_configure_file(array $configure) {
        if (!function_exists('file_put_contents')) {
            throw new Here_Exceptions_FatalError('function `file_put_contents` not found',
                'Here:Api:Installer:_create_configure_file');
        }
        // configure template contents
        $template = file_get_contents(_here_user_configure_template_, true);
        // replace database configure
        $template = str_replace('$database_host$', $configure['database']['host'], $template);
        $template = str_replace('$database_port$', $configure['database']['port'], $template);
        $template = str_replace('$database_username$', $configure['database']['username'], $template);
        $template = str_replace('$database_password$', $configure['database']['password'], $template);
        $template = str_replace('$database_database$', $configure['database']['dbname'], $template);
        $template = str_replace('$table_prefix$', $configure['database']['table_prefix'], $template);
        // cache server configure
        /* @TODO cache configure */
        if (file_put_contents(_here_user_configure_, $template) === false) {
            throw new Here_Exceptions_FatalError('create configure error occurs',
                'Here:Api:Installer:_create_configure_file');
        }
    }

    /**
     * check blog installed
     */
    private function _check_installed() {
        if (is_file(_here_user_configure_)) {
            Here_Request::abort(403);
        }
    }

    /**
     * make response to client
     *
     * @param bool $success
     * @param string|null $message
     * @param mixed|null $data
     */
    private function _make_detect_response($success, $message = null, $data = null) {
        if ($message === null) {
            $message = 'success';
        }

        Here_Response::json_response(array(
            'status' => $success ? 0 : 1,
            'message' => $message,
            'extra_data' => $data
        ));
    }
}
