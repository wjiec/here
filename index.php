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
use Here\Lib\Ext\Callback\CallbackObject;
use Here\Lib\Io\Filter\Sanitizer\NumberSanitizer;
use Here\Lib\Io\Filter\Validator\CallbackValidator;
use Here\Lib\Io\Input\Request;

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
var_dump(Request::get_param_safe(new NumberSanitizer(), 'pageSize', 16));

$callback_filter = new CallbackValidator(new CallbackObject(function($string) {
    return trim($string);
}));
// http://127.0.0.1/?pageSize=asd123asd&article=%20%20blank
var_dump(Request::get_param_safe($callback_filter, 'article', 'valid_title'));
