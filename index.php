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
require_once 'Here/Route.php';

// DEBUG:
//      php -S 0.0.0.0:9527
/*
(new Route())
->error('404', function($params) {
    echo '404' . ' ' . $params;
})
->error('404', 'Not Found'); // curl -v 127.0.0.1:9527 -> '404 Not Found'
*/

/*
(new Route())
->error('404', function($params) {
    header("HTTP/1.1 404 Not Found");
    include 'default/404.php';
})
->hook('print', function($params) {
    echo "<br>HOOK: print<br>";

    var_dump($params);
})
->get('/', function($params) {
    var_dump($params);
    
    echo '<br>GET /<br>';
})
->get('/hello/world/', function($params) {
    echo '<br>GET /hell/world/<br>';
}, 'print') // add hook
->get('/license.php', function($params) {
    include 'default/license.php';
})
->execute();
*/

(new Route(true))
->error('404', function($params) {
    header("HTTP/1.1 404 Not Found");
    include 'default/404.php';
    var_dump($params);
})
->hook('print', function($params) {
    echo "<br>HOOK: print<br>";
    var_dump($params);
})
->get('/', function($params) {
    var_dump($params);
    echo '<br>GET /<br>';
})
->get('/hello/world', function($params) {
    var_dump($params);
})
->get('/hello/$name/', function($params) {
    
})
->get('/hello/$name/$mid', function($params) {

})
->execute()
;

if (!defined('__HERE_ROOT_DIRECTORY__') && !@include_once 'config.php') {
    file_exists('./install.php') ? header('Location: install.php') : print('Missing Config File');
    exit;
}
