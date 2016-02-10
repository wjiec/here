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

// XSS Attack
if (!empty($_GET) || !empty($_POST)) {
    if (empty($_SERVER['HTTP_REFERER'])) {
        exit;
    }

    $parts = parse_url($_SERVER['HTTP_REFERER']);
    if (!empty($parts['port'])) {
        $parts['host'] = "{$parts['host']}:{$parts['port']}";
    }

    if (empty($parts['host']) || $_SERVER['HTTP_HOST'] != $parts['host']) {
        exit;
    }
}

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
