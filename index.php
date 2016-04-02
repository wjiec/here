<?php
/**
 * Thank for you reading this blog application.
 * 
 * @package Here
 * @author  ShadowMan
 */
# Root Directory
define('__HERE_ROOT_DIRECTORY__', dirname(__FILE__));

# Admin Directory
define('__HERE_ADMIN_DIRECTORY__', '/admin');

# Common Directory
define('__HERE_CORE_DIRECTORY__', '/include/Core');

# Core Class Directory
define('__HERE_CLASS_DIRECTORY__', '/include/Core/Here');

# Plugins Directory
define('__HERE_PLUGINS_DIRECTORY__', '/include/Plugins');

# Theme Directory
define('__HERE_THEME_DIRECTORY__', '/include/Theme');

@set_include_path(get_include_path() . PATH_SEPARATOR.
    __HERE_ROOT_DIRECTORY__ . __HERE_ADMIN_DIRECTORY__ . PATH_SEPARATOR.
    __HERE_ROOT_DIRECTORY__ . __HERE_CORE_DIRECTORY__ . PATH_SEPARATOR.
    __HERE_ROOT_DIRECTORY__ . __HERE_CLASS_DIRECTORY__ . PATH_SEPARATOR.
    __HERE_ROOT_DIRECTORY__ . __HERE_PLUGINS_DIRECTORY__ . PATH_SEPARATOR.
    __HERE_ROOT_DIRECTORY__ . __HERE_THEME_DIRECTORY__ . PATH_SEPARATOR
);

ob_start();
session_start();

# Core API
require_once 'Here/Core.php';

// # Config Support
// require_once 'Here/Config.php';

# Theme Support
require_once 'Here/Theme.php';

# Router Support
require_once 'Here/Router.php';

# Request Filter
require_once 'Here/Intercepter.php';

# Init Environment
Core::init();
Intercepter::init();
Core::router()->execute();
