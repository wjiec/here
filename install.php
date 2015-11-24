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
    <script src="/include/Resource/js/library/jquery.pjax.js"></script>
    <script src="/include/Resource/js/installer.js"></script>
</head>
<body>
    <div id="_Here-Installer" class="container-fluid">
        <div class="row">
            <section id="_Here-Installer-Header" class="widget-align-vh">
                <h1>Here Installer</h1>
            </section>
            <section id="_Here-Installer-Container" class="col-6 col-offset-3 col-sm-8 col-sm-offset-2">
                <h2 class="widget-hidden">Here Installer Guide</h2>
                <div id="_Here-Replace-Container">
                    <h3>Welcome to <strong>Here</strong>.</h3>
                    <p>Before getting started, we need some information on the database. You will need to know the following items before proceeding.</p>
                    <ul>
                        <li>Database name</li>
                        <li>Database username</li>
                        <li>Database password</li>
                        <li>Database host</li>
                        <li>Table prefix (if you want to run more than one WordPress in a single database)</li>
                        <li></li>
                    </ul>
                </div>
            </section>
        </div>
    </div>
</body>
</html>
