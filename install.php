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
require_once 'Class/Class.Core.php';

# Init env
Core::init();

// echo Parsedown::instance()->line('![Baidu](https://ss0.bdstatic.com/5aV1bjqh_Q23odCf/static/superplus/img/logo_white_ee663702.png)');

function __res($path) {
    echo Core::__res($path);
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Here Installer</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="format-detection" content="telephone=no"/>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0" />
<!-- <link rel="stylesheet" href="<?php __res('include/Resource/css/library/bootstrap-v4-alpha.min.css')?>" media="all" /> -->
    <link rel="stylesheet" href="<?php __res('include/Resource/css/style.css')?>" media="all" />
    <link rel="stylesheet" href="<?php __res('include/Resource/css/module/install.css')?>" media="all" />
    <script src="<?php __res('include/Resource/js/library/jquery-2.1.4.min.js')?>"></script>
    <script src="<?php __res('include/Resource/js/here.js')?>"></script>
</head>
<body>
    <div class="container-fluid _Here_border" id="_Here-Installer">
        <div class="row">
            <section id="_Here-Installer-Header" class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-8 col-xs-offset-2">
                <h3>Here Installer</h3>
            </section>
            <section id="_Here_Installer-Container" class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-12">
                <h3 class="hidden">Here Install Info</h3>
                <div></div>
            </section>
        </div>
    </div>

<div class="container" id="test">
        <div class="row">
          <div class="col-md-1">.col-md-1</div>
          <div class="col-md-1">.col-md-1</div>
          <div class="col-md-1">.col-md-1</div>
          <div class="col-md-1">.col-md-1</div>
          <div class="col-md-1">.col-md-1</div>
          <div class="col-md-1">.col-md-1</div>
          <div class="col-md-1">.col-md-1</div>
          <div class="col-md-1">.col-md-1</div>
          <div class="col-md-1">.col-md-1</div>
          <div class="col-md-1">.col-md-1</div>
          <div class="col-md-1">.col-md-1</div>
          <div class="col-md-1">.col-md-1</div>
        </div>
        <div class="row">
          <div class="col-md-8">.col-md-8</div>
          <div class="col-md-4">.col-md-4</div>
        </div>
        <div class="row">
          <div class="col-md-4">.col-md-4</div>
          <div class="col-md-4">.col-md-4</div>
          <div class="col-md-4">.col-md-4</div>
        </div>
        <div class="row">
          <div class="col-md-6">.col-md-6</div>
          <div class="col-md-6">.col-md-6</div>
        </div>
        <br />
        <!-- Stack the columns on mobile by making one full-width and the other half-width -->
        <div class="row">
          <div class="col-xs-12 col-md-8">.col-xs-12 .col-md-8</div>
          <div class="col-xs-6 col-md-4">.col-xs-6 .col-md-4</div>
        </div>
        
        <!-- Columns start at 50% wide on mobile and bump up to 33.3% wide on desktop -->
        <div class="row">
          <div class="col-xs-6 col-md-4">.col-xs-6 .col-md-4</div>
          <div class="col-xs-6 col-md-4">.col-xs-6 .col-md-4</div>
          <div class="col-xs-6 col-md-4">.col-xs-6 .col-md-4</div>
        </div>
        
        <!-- Columns are always 50% wide, on mobile and desktop -->
        <div class="row">
          <div class="col-xs-6">.col-xs-6</div>
          <div class="col-xs-6">.col-xs-6</div>
        </div>
        <br />
        <div class="row">
          <div class="col-xs-12 col-sm-6 col-md-8">.col-xs-12 .col-sm-6 .col-md-8</div>
          <div class="col-xs-6 col-md-4">.col-xs-6 .col-md-4</div>
        </div>
        <div class="row">
          <div class="col-xs-6 col-sm-4">.col-xs-6 .col-sm-4</div>
          <div class="col-xs-6 col-sm-4">.col-xs-6 .col-sm-4</div>
          <!-- Optional: clear the XS cols if their content doesn't match in height -->
          <div class="clearfix visible-xs-block"></div>
          <div class="col-xs-6 col-sm-4">.col-xs-6 .col-sm-4</div>
        </div>
        <br />
        <div class="row">
          <div class="col-md-4">.col-md-4</div>
          <div class="col-md-4 col-md-offset-4">.col-md-4 .col-md-offset-4</div>
        </div>
        <div class="row">
          <div class="col-md-3 col-md-offset-3">.col-md-3 .col-md-offset-3</div>
          <div class="col-md-3 col-md-offset-3">.col-md-3 .col-md-offset-3</div>
        </div>
        <div class="row">
          <div class="col-md-6 col-md-offset-3">.col-md-6 .col-md-offset-3</div>
        </div>
</div>
</body>
</html>
