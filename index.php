<?php
/**
 * Thank for you reading this blog application.
 * 
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016 ShadowMan
 * @license   MIT License
 * @version   Develop: 0.1.0
 * @link      https://github.com/JShadowMan/here
 */

# Root Directory
define('__HERE_ROOT_DIRECTORY__', str_replace('\\', '/', dirname(__FILE__)));

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
    __HERE_ROOT_DIRECTORY__ . __HERE_CORE_DIRECTORY__ . PATH_SEPARATOR.
    __HERE_ROOT_DIRECTORY__ . __HERE_ADMIN_DIRECTORY__ . PATH_SEPARATOR.
    __HERE_ROOT_DIRECTORY__ . __HERE_CLASS_DIRECTORY__ . PATH_SEPARATOR.
    __HERE_ROOT_DIRECTORY__ . __HERE_THEME_DIRECTORY__ . PATH_SEPARATOR.
    __HERE_ROOT_DIRECTORY__ . __HERE_PLUGINS_DIRECTORY__ . PATH_SEPARATOR
);

# Core API
require_once 'Here/Core.php';

# Theme Support
require_once 'Here/Theme.php';

# Router Support
require_once 'Here/Router.php';

# Request Filter
require_once 'Here/Intercepter.php';

# Init Environment
Core::init();

# Intercepter Init
Interceptor::init();

// Create Router
Manager_Widget::widget('router')->start();

# Entry
Core::router()->execute();
