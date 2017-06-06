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
                    'address' => '/api/v1/installer/check_web_server',
                    'fail_level' => 'Warning'
                ),
                array(
                    'name' => 'Rewrite Support',
                    'address' => '/api/v1/installer/check_rewrite',
                    'fail_level' => 'Error'
                ),
                array(
                    'name' => 'Python',
                    'address' => '/api/v1/installer/check_python_support',
                    'fail_level' => 'Warning'
                ), array(
                    'name' => 'Write Permissions',
                    'address' => '/api/v1/installer/check_write_permissions',
                    'fail_level' => 'Warning'
                ), array(
                    'name' => 'Database Adapter',
                    'address' => '/api/v1/installer/check_database_adapter',
                    'fail_level' => 'Error'
                )
            ),
            'next_step_url' => '/api/v1/installer/next_step'
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
        // make response
        $this->_make_detect_response(true, '755');
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
            // connecting to server and get server|client information
            Here_Response::json_response($helper->get_adapter_info());
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
        // make response
        Here_Response::json_response(array(
            'status' => 0,
            'message' => 'success'
        ));
    }

    /**
     * check blog installed
     */
    private function _check_installed() {
        if (is_file(_here_user_configure)) {
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
