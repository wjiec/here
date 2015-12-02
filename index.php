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

@set_include_path(get_include_path() . PATH_SEPARATOR.
    __HERE_ROOT_DIRECTORY__ . __HERE_COMMON_DIRECTORY__ . PATH_SEPARATOR.
    __HERE_ROOT_DIRECTORY__ . __HERE_ADMIN_DIRECTORY__ . PATH_SEPARATOR.
    __HERE_ROOT_DIRECTORY__ . __HERE_CORE_DIRECTORY__ . PATH_SEPARATOR
);
ob_start();

# Route API
require_once 'Here/Route.php';

class Handle {
    public function handle_401() {
        echo '401';
    }
}

(new Route())
->error('401', array('Handle', 'handle_401'))
->error('403', function() {
    echo '403';
})
->error('404', function() {
    echo '404';
})
->get('/', function($params) {
    echo 'Hello';
});

die(); # Route Debug


if (!defined('__HERE_ROOT_DIRECTORY__') && !@include_once 'config.php') {
    file_exists('./install.php') ? header('Location: install.php') : print('Missing Config File');
    exit;
}
