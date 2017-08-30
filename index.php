<?php
/**
 * Simple Blogger <Here>
 * 
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @version   Develop: 0.1.0
 * @link      https://github.com/JShadowMan/here
 */
namespace Here;
use Here\Lib\Autoloader;
use Here\Lib\Exception\AutoloaderError;
use Here\Lib\Toolkit;


/* root absolute path with `Here` */
define('__HERE_ROOT_DIRECTORY__', str_replace('\\', '/', dirname(__FILE__)));

/* the only explicit `require_once` to include `Autoloader` */
require_once 'lib/Autoloader.php';

/* register root directory (must be call first) */
Autoloader::set_root('Here', __HERE_ROOT_DIRECTORY__);

/* register `Here\Lib` namespace */
Autoloader::register('Here\\Lib', '/lib');

/* `Autoloader` test case */
new Toolkit();
throw new AutoloaderError("test autoloader");
//# root directory
//define('__HERE_ROOT_DIRECTORY__', str_replace('\\', '/', dirname(__FILE__)));
//
//# /bin directory
//define('__HERE_BIN_DIRECTORY__', '/bin');
//
//# /etc directory
//define('__HERE_ETC_DIRECTORY__', '/etc');
//
//# /home directory
//define('__HERE_HOME_DIRECTORY__', '/home');
//
//# /sbin directory
//define('__HERE_SBIN_DIRECTORY__', '/sbin');
//
//# /tmp directory
//define('__HERE_TMP_DIRECTORY__', '/tmp');
//
//# /usr directory
//define('__HERE_USR_DIRECTORY__', '/usr');
//
//# /var directory
//define('__HERE_VAR_DIRECTORY__', '/var');
//
//# set include path
//@set_include_path(get_include_path() . PATH_SEPARATOR.
//    __HERE_ROOT_DIRECTORY__ . __HERE_BIN_DIRECTORY__ . PATH_SEPARATOR.
//    __HERE_ROOT_DIRECTORY__ . __HERE_ETC_DIRECTORY__ . PATH_SEPARATOR.
//    __HERE_ROOT_DIRECTORY__ . __HERE_HOME_DIRECTORY__ . PATH_SEPARATOR.
//    __HERE_ROOT_DIRECTORY__ . __HERE_SBIN_DIRECTORY__ . PATH_SEPARATOR.
//    __HERE_ROOT_DIRECTORY__ . __HERE_TMP_DIRECTORY__ . PATH_SEPARATOR.
//    __HERE_ROOT_DIRECTORY__ . __HERE_USR_DIRECTORY__ . PATH_SEPARATOR.
//    __HERE_ROOT_DIRECTORY__ . __HERE_VAR_DIRECTORY__ . PATH_SEPARATOR
//);
//
//# Here core API
//require_once 'Here/Core.php';
//
//# Initialize environment
//Core::init();
//
//# single entry
//Core::router_instance()->entry();
