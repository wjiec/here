<?php
/**
 * Here System Configure
 * 
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */

/**
 * Blog Http protocol version
 *
 * @TODO HTTP/2.0
 */
define('_here_http_protocol_', 'HTTP/1.1');

/**
 * Enable https, blog judge automatically
 */
define('_here_enable_https_', false);

/**
 * blog default charset, recommend "utf-8"
 */
define('_here_default_charset_', 'utf-8');

/**
 * path separator
 */
define('_here_path_separator_', '/');

/**
 * url separator
 */
define('_here_url_separator_', '/');

/**
 * user router tables path
 */
define('_here_user_router_table_', 'etc/router.php');

/**
 * system router tables path
 */
define('_here_sys_default_router_table_', 'etc/sys/default_router.php');

/**
 * default forbidden list
 *
 * @TODO forbidden list
 */
define('_here_sys_default_ip_policy_', 'etc/sys/default_ip_policy.php');

/**
 * configure file path, generate by installer/recovery guide
 */
define('_here_user_configure', 'etc/configure.php');

/**
 * installer guide file path
 */
define('_here_installer_file_', 'var/installer/installer.php');

/**
 * installer guide url
 */
define('_here_install_url_', '/installer-guide');

/**
 * error code raise with hook function validate failure 
 */
define('_here_hook_emit_error_', '403');

/**
 * hook function error occurs after exit
 */
define('_here_hook_error_after_exit_', true);

/**
 * error occurs after exit
 */
define('_here_emit_error_after_exit_', true);

/**
 * enable recovery mode
 */
define('_here_enable_recovery_mode', false);

/**
 * recovery guide address
 */
define('_here_recovery_url_', '/recovery-guide');

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

/**
 * blog page cache server.
 * 
 * Server:
 *      memcached
 *      redis
 *      null
 *
 * @TODO cache controller
 */
define('_here_cache_server_', 'memcached');

/**
 * database connecting timeout
 */
define('_here_database_connecting_timeout_', 1);

/**
 * static/resource url prefix
 */
define('_here_static_url_prefix_', '/static/');

/**
 * default jwt encrypt key
 */
define('_here_default_jwt_key_', ':Here*Like+Rhp@WsM:');
