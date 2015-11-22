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

# Init env
Core::init();

// echo Parsedown::instance()->line('![Baidu](https://ss0.bdstatic.com/5aV1bjqh_Q23odCf/static/superplus/img/logo_white_ee663702.png)');
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Here Installer</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="format-detection" content="telephone=no"/>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0" />
    <link rel="stylesheet" href="include/Resource/css/library/grid-alpha.css" media="all" />
    <link rel="stylesheet" href="include/Resource/css/module/install.css" media="all" />
    <script src="include/Resource/js/library/jquery-2.1.4.min.js"></script>
    <script src="include/Resource/js/here.js"></script>
</head>
<body>
    <div id="_Here-Installer" class="container-fluid">
        <div class="row">
            <section id="_Here-Installer-Header" class="widget-align-vh">
                <h3>Here Installer</h3>
            </section>
            <section id="_Here-Installer-Container" class="col-6 col-offset-3">
                <h3 class="widget-hidden">Here Installer Guide</h3>
                <div id="_Here-Replace-Container">
                    <h4>Welcome to the  programs wizard.</h4>
                    <section>
                    </section>
                </div>
            </section>
        </div>
    </div>
</body>
</html>
