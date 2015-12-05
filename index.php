<?php
/**
 * Thank for you reading this blog application.
 * 
 * @package Here
 * @author  ShadowMan
 */
# TODO Route
############################################################
error_reporting(E_ALL);

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

# Route API
require_once 'Here/Router.php';

(new Route())
->error('401', function($params, $message = null) {
    header("HTTP/1.1 401 Authorization Required");
    echo "401" . '<br>' . $message;
    die($message);
})
->hook('check', function($params) {
    if ($params['_data']['name'] != 'shadowman') {
        $params['this']->error('401', $params, "please log in");
    }
})
->get('/$name', function($params) {
    echo "name: " . $params['_data']['name'];
}, ['check'])
->execute();

if (!defined('__HERE_ROOT_DIRECTORY__') && !@include_once 'config.php') {
    file_exists('./install.php') ? header('Location: install.php') : print('Missing Config File');
    exit;
}
