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
use Here\Lib\Ext\Regex\Regex;
use Here\Lib\Io\Filter\StringFilter;


/* root absolute path with `Here` */
define('__HERE_ROOT_DIRECTORY__', str_replace('\\', '/', dirname(__FILE__)));

/* the only explicit `require_once` to include `Autoloader` */
require_once 'lib/Autoloader.php';

/* register root directory (must be call first) */
Autoloader::set_root('Here', __HERE_ROOT_DIRECTORY__);

/* register `Here\Lib` namespace */
Autoloader::register('Here\\Lib', '/lib');

/* register `Here\Conf` namespace */
Autoloader::register('Here\\Config', '/etc');

/* `Here` test case */
//$filter = (new StringFilter())->validate('email', 0);
//var_dump($filter->apply('valid@example.com'));
//var_dump($filter->apply('invalid@emial@example.com'));
new Regex('/^asd($/');