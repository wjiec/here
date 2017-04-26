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

# root directory
define('__HERE_ROOT_DIRECTORY__', str_replace('\\', '/', dirname(__FILE__)));

# /bin directory
define('__HERE_BIN_DIRECTORY__', '/bin');

# /etc directory
define('__HERE_ETC_DIRECTORY__', '/etc');

# /home directory
define('__HERE_HOME_DIRECTORY__', '/home');

# /sbin directory
define('__HERE_SBIN_DIRECTORY__', '/sbin');

# /tmp directory
define('__HERE_TMP_DIRECTORY__', '/tmp');

# /usr directory
define('__HERE_USR_DIRECTORY__', '/usr');

# /var directory
define('__HERE_VAR_DIRECTORY__', '/var');

# set include path
@set_include_path(get_include_path() . PATH_SEPARATOR.
    __HERE_ROOT_DIRECTORY__ . __HERE_BIN_DIRECTORY__ . PATH_SEPARATOR.
    __HERE_ROOT_DIRECTORY__ . __HERE_ETC_DIRECTORY__ . PATH_SEPARATOR.
    __HERE_ROOT_DIRECTORY__ . __HERE_HOME_DIRECTORY__ . PATH_SEPARATOR.
    __HERE_ROOT_DIRECTORY__ . __HERE_SBIN_DIRECTORY__ . PATH_SEPARATOR.
    __HERE_ROOT_DIRECTORY__ . __HERE_TMP_DIRECTORY__ . PATH_SEPARATOR.
    __HERE_ROOT_DIRECTORY__ . __HERE_USR_DIRECTORY__ . PATH_SEPARATOR.
    __HERE_ROOT_DIRECTORY__ . __HERE_VAR_DIRECTORY__ . PATH_SEPARATOR
);

# Here core API
require_once 'Here/core.php';

# Initialize environment
Core::init();

# single entry
Core::router_instance()->entry();
