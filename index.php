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

/* blogger environment initializing */
Blogger::init();

/* start blogger service */
Blogger::start_service();
