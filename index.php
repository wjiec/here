<?php
/**
 * Simple Blogger <Here>
 *
 * @package   Here
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2018 ShadowMan
 * @license   MIT License
 * @version   Develop: 0.0.1
 * @link      https://github.com/JShadowMan/here
 */

/* enable strict mode */
declare(strict_types=1);

/* namespaces definitions */
namespace Here;
use Here\App\Blogger\Blogger;
use Here\Config\Constant\SysEnvironment;
use Here\Lib\Environment\GlobalEnvironment;
use Here\Lib\Loader\Autoloader;


/** @TODO List
 *
 * Default error page
 * I18n
 *
 */


/* the only explicit `require_once` to include `Autoloader` */
require_once 'Lib/Loader/Autoloader.php';

/* register classes loader and set default namespace */
Autoloader::add_namespace(__NAMESPACE__, __DIR__);

/* cli mode just only debug */
if (php_sapi_name() === 'cli') {
    $_GET = array('auth' => 'token');
    GlobalEnvironment::set_user_env(SysEnvironment::ENV_REQUEST_METHOD, 'get');
    GlobalEnvironment::set_user_env(SysEnvironment::ENV_REQUEST_URI, '/dashboard?auth=token');
}

/* create `Blogger` instance */
$blogger = new Blogger();

/* start blogger service */
$blogger->start_service();
