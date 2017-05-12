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
    public function next_step(array $parameters) {
        var_dump($this, $parameters, Here_Request::get_request_headers(), Here_Request::get_remote_ip());
    }

    /**
     * check server is available
     *
     * @param array $parameters
     */
    public function check_server(array $parameters) {
        // check installed
        $this->_check_installed();
        // return all check step
        Here_Response::json_response(array(
            'url_prefix' => Here_Request::get_url_prefix(),
            'step_count' => 3,
            'steps' => array(
                array(
                    'name' => 'Python Support',
                    'address' => '/api/v1/installer/check_python_support',
                    'fail_level' => 'Warning'
                ), array(
                    'name' => 'Write Permissions',
                    'address' => '/api/v1/installer/check_write_permissions',
                    'fail_level' => 'Warning'
                ), array(
                    'name' => 'Database Adapter Available',
                    'address' => '/api/v1/installer/check_database_adapter',
                    'fail_level' => 'Error'
                )
            )
        ));
    }

    /**
     * @param array $parameters
     */
    public function check_python_support(array $parameters) {
        // check installed
        $this->_check_installed();

    }

    public function check_database_adapter(array $parameters) {
        // check installed
        $this->_check_installed();
    }

    private function _check_installed() {
        if (is_file(_here_user_configure)) {
            Here_Request::abort(403);
        }
    }
}