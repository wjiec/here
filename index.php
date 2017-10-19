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

/* enable strict mode */
declare(strict_types=1);

/* namespaces definitions */
namespace Here;
use Here\Lib\Loader\Autoloader;
use Here\Lib\Env\GlobalEnvironment;

/* the only explicit `require_once` to include `Autoloader` */
require_once 'Lib/Loader/Autoloader.php';

/* register classes loader and set default namespace */
Autoloader::add_namespace(__NAMESPACE__, __DIR__);

var_dump(GlobalEnvironment::get_server_env('not_found', 'default value'));
var_dump(GlobalEnvironment::get_server_env('script_filename', 'default value'));
var_dump(GlobalEnvironment::get_user_env('script_filename', 'default value'));
var_dump(GlobalEnvironment::set_user_env('username', 'Wang'));
var_dump(GlobalEnvironment::get_user_env('username', 'default value'));
var_dump(GlobalEnvironment::get_env('username', 'default value'));
var_dump(GlobalEnvironment::get_env('script_filename'));
var_dump(GlobalEnvironment::get_env('not_found', 'default_value'));
var_dump(GlobalEnvironment::set_user_env('script_filename', 'index.php'));
var_dump(GlobalEnvironment::get_env('script_filename', 'default value'));
