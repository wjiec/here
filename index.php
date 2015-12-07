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
    $params['theme']->_404();
})
->get(['/', '/index.php'], function(){
    if (!@include_once 'config.php') {
        file_exists('admin/install/install.php') ? include 'install/install.php' : print('Missing Config File'); exit(1);
    }
})
->get('license.php', function($params) {
    $params['theme']->license();
})
->execute(['theme' => $theme]);
