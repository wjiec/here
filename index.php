<?php
/**
 * Thank for you reading this blog application.
 * 
 * @package Here
 * @author  ShadowMan
 */
// TODO oauth2.0


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
require_once 'Here/Intercepter.php';
require_once 'Here/Request.php';
require_once 'Here/Router.php';
require_once 'Here/Theme.php';
require_once 'Here/DB.php';

# Init env
Core::init();
Intercepter::init();

// TODO React: After the long long time
// TODO RESTful API
Core::setRouter((new Router())
->error('404', function($params, $message = null) {
    Theme::_404($message ? $message : null);
})
->get(['/', '/index.php'], function($params){
    if (!@include_once 'config.php') {
        file_exists('admin/install/install.php') ? header('Location: install.php') : print('Missing Config File'); exit(1);
    }
})
->get('install.php', function($params){
    if (!@include_once 'config.php') {
        file_exists('admin/install/install.php') ? include 'install/install.php' : print('Missing Config File'); exit(1);
    }
    exit;
})
->get('license.php', function($params) {
    Theme::_license();
})
->get('/admin/', function($params) {
    if (!@include_once 'config.php') {
        file_exists('admin/install/install.php') ? header('Location: install.php') : print('Missing Config File'); exit;
    }
    is_file('admin/index.php') ? include 'admin/index.php' : print('FATAL ERROR'); exit;
})
->get(['/controller/$controller/$action', '/controller/$controller/$action/$value'], function($params) {
    try {
        Request::s($params['action'], isset($params['value']) ? $params['value'] : null);
        Controller::$params['controller']($params['action']);
    } catch (Exception $e) {
        Theme::_404($e->getMessage());
    }
})
->execute());
