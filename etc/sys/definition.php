<?php
/**
 * Here System Configure
 * 
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */

/**
 * Blog Http protocol version
 *
 * @TODO HTTP/2.0
 */
define('_here_http_protocol_', 'HTTP/1.1');

# http or https
define('_here_enable_https_', false);

# default charset
define('_here_default_charset_', 'utf-8');

# path separator
define('_here_path_separator_', '/');

# url separator
define('_here_url_separator_', '/');

# user router table
define('_here_user_router_table_', 'etc/router.php');

# default router table
define('_here_sys_default_router_table_', 'etc/sys/default_route.php');

# default forbidden list
define('_here_sys_default_ip_policy_', 'etc/sys/default_ip_policy.php');

# configure file, generate by install guide
define('_here_user_configure', 'etc/configure.php');

# install guide file path
define('_here_install_file_', 'var/install/install.php');

# install guide url
define('_here_install_url_', '/installer-guide');

# error code raise with hook function validate failure 
define('_here_hook_emit_error_', '403');

# hook function error occurs after exit
define('_here_hook_error_after_exit_', true);

# hook function error occurs after exit
define('_here_emit_error_after_exit_', true);

# recover mode
define('_here_enable_recovery_mode', false);

/**
 * if exception level bigger than that, we must notification admin
 *
 * Exception Level:
 *      Fatal: 100
 *      Error: 75
 *      Warning: 50
 *      Ignore: 25
 */
define('_here_notification_level', 100);
