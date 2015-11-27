<?php
/**
 * HERE Install Program
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
require_once 'Here/Route.php';

# Init env
Core::init();

function _u($path) {
    echo 'http://' . $_SERVER['HTTP_HOST'] . '/' . $path;
}

// echo Parsedown::instance()->line('![Baidu](https://ss0.bdstatic.com/5aV1bjqh_Q23odCf/static/superplus/img/logo_white_ee663702.png)'); die();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Here Installer</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="format-detection" content="telephone=no"/>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0" />
    <link rel="stylesheet" href="/include/Resource/css/library/grid-alpha.css" media="all" />
    <link rel="stylesheet" href="/include/Resource/css/module/install.css" media="all" />
    <script src="/include/Resource/js/library/jquery-2.1.4.min.js"></script>
<!--     <script src="/include/Resource/js/library/jquery.pjax.js"></script> -->
    <script src="/include/Resource/js/installer.js"></script>
</head>
<body>
    <div id="_Here-Installer" class="container-fluid">
        <div class="row">
            <section id="_Here-Installer-Header" class="widget-align-vh">
                <h1>Here Installer</h1>
            </section>
            <section id="_Here-Installer-Container" class="col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
                <h2 class="widget-hidden">Here Installer Guide</h2>
                <div id="_Here-Replace-Container">
                    <h3>Welcome to Here.</h3>
                    <p>Here is distributed under the <a href="<?php _u('license.php'); ?>" target="_blank">MIT</a> license.</p>
                    <p>This Installer will automatically detect server environment is in line with the minimum configuration requirements. If not meet,  please follow the instructions in your host configuration information to check if the server environment to meet the requirements</p>
                </div>
            </section>
            <section id="_Here-Server-Env">
                <h3 class="widget-hidden">Detect Server Environment</h3>
            </section>
        </div>
        <div id="_Here-Next-Step" class="row">
            <button id="_Next-Step-Btn" class="widget-btn col-lg-offset-3 col-md-offset-2 col-sm-offset-1">Next Step</button>
        </div>
    </div>
</body>
</html>
