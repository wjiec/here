<?php
/**
 * Here.Widget.Router
 * 
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */

class Here_Widget_Router extends Here_Abstracts_Widget {
    private static $_single_router_instance = null;

    public function __construct(array $options = array()) {
        $this->_widget_name = 'Widget_Router';
        $this->_widget_options = array_merge($this->_widget_options, $options);

        if (self::$_single_router_instance instanceof Here_Router) {
            throw new Exception('Here_Widget_Router is single class', 1996);
        }

        self::$_single_router_instance = new Here_Router();
    }

    public function import_router_table($router_table) {
        if (is_file($router_table)) {
            self::$_single_router_instance->import_router_table($router_table);
        } else {
            throw new Exception('The router table file not found', 500);
        }
    }

    public function router_instance() {
        return self::$_single_router_instance;
    }

    public function current_url() {
        return self::$_single_router_instance->current_url();
    }

    public function redirection($new_url) {
        Here_Request::redirection($new_url);
    }

    public function error($errno, $error) {
        self::$_single_router_instance->emit_error($errno, $error);
    }

    public function _router_install($params) {
        if (is_file(_here_install_file_)) {
            include _here_install_file_;
        } else {
            self::$_single_router_instance->error('500', array('error' => 'Missing install file'));
        }
    }

    public function _router_index($params) {
        echo '<h1>Index Homepage</h1>';
        var_dump($params);
    }

    public function _router_article($params) {
        echo '<h1>Articles List</h1>';
        var_dump($params);
    }

    public function _router_message($params) {
        echo '<h1>All Messages</h1>';
        var_dump($params);
    }

    public function _router_repo($params) {
        echo '<h1>All Repo</h1>';
        var_dump($params);
    }

    public function _router_license($params) {
        echo '<h1>Blog License</h1>';
        var_dump($params);
    }

    public function _router_404_error($params) {
        Here_Request::error('404', 'Not Found');

        echo '<h1>Sorry, this page is loss</h1>';
        var_dump($params);
    }

    public function _router_500_error($params) {
        echo '<h1>500 Server Internal Error</h1>';
        var_dump($params);
    }

    public function _router_hook_authentication($params) {
        echo '<h1>Check Authentiation</h1>';
        var_dump($params);

        return true;
    }

    public function _router_check_install($params) {
        return !(is_file(_here_user_configure));
    }

    public function __clone() {
        throw new Exception('Here_Widget_Router is single class', 1996);
    }
}
