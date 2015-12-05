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
require_once 'Here/Router.php';

# Init env
Core::init();
(new Router())
->get('/', function() {
    header('Location: install.php');
})
->get('/index.php', function() {
    header('Location: install.php');
})
->get('/license.php', function($params) {
    include 'default/license.php';
})
->post('/index.php', function($params) {
    var_dump($_POST);
})
->execute();

if (!defined('__HERE_ROOT_DIRECTORY__') && !@include_once 'config.php') {
    file_exists('./install.php') ? header('Location: install.php') : print('Missing Config File');
    exit;
}
