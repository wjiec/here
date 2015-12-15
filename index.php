<?php
/**
 * Thank for you reading this blog application.
 * 
 * @package Here
 * @author  ShadowMan
 */

# Root Directory
define('__HERE_ROOT_DIRECTORY__', dirname(__FILE__));

# Common Resource Directory
define('__HERE_COMMON_DIRECTORY__', '/include');

# Admin Resource Directory
define('__HERE_ADMIN_DIRECTORY__', '/admin');

# Core Resource Directory
define('__HERE_CORE_DIRECTORY__', '/include/Core');

# Plugins Directory
define('__HERE_PLUGINS_DIRECTORY__', '/include/Plugins');

# Theme Directory
define('__HERE_THEME_DIRECTORY__', '/include/Theme');

@set_include_path(get_include_path() . PATH_SEPARATOR.
    __HERE_ROOT_DIRECTORY__ . __HERE_COMMON_DIRECTORY__ . PATH_SEPARATOR.
    __HERE_ROOT_DIRECTORY__ . __HERE_ADMIN_DIRECTORY__ . PATH_SEPARATOR.
    __HERE_ROOT_DIRECTORY__ . __HERE_CORE_DIRECTORY__ . PATH_SEPARATOR.
    __HERE_ROOT_DIRECTORY__ . __HERE_PLUGINS_DIRECTORY__ . PATH_SEPARATOR.
    __HERE_ROOT_DIRECTORY__ . __HERE_THEME_DIRECTORY__ . PATH_SEPARATOR
);

ob_start();
session_start();

# Core API
require_once 'Here/Core.php';

# Init env
Core::init();

$theme = new Theme();
(new Router())
->error('404', function($params, $message = '') {
    $params['_theme']->_404($message ? $message : null);
})
->get(['/', '/index.php'], function($params){
    if (!@include_once 'config.php') {
        file_exists('admin/install/install.php') ? header('Location: install.php') : print('Missing Config File'); exit(1);
    }
})
->get('install.php', function($params){
    if (!@include_once 'config.php') {
        file_exists('admin/install/install.php') ? include 'install/install.php' : print('Missing Config File'); exit(1);
    } else {
        exit(1);
    }
})
->get('license.php', function($params) {
    $params['_theme']->_license();
})
->get('/admin/', function($params) {
    if (!@include_once 'config.php') {
        file_exists('admin/install/install.php') ? header('Location: install.php') : print('Missing Config File'); exit(1);
    }
    file_exists('admin/index.php') ? include 'admin/index.php' : print('FATAL ERROR'); exit(1);
})
->request('/controller/$controller/$action', function($params) {
    try {
        call_user_func_array('Controller::request', $params['_data']);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
})
->get('pjax/$controller/$action', function($params) {
    try {
        call_user_func_array('Controller::request', $params['_data']);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
})
->execute(['_theme' => &$theme]);
