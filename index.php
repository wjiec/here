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
use Here\Lib\Io\Filter\Validator\IpValidator;
use Here\Lib\Io\Filter\Validator\EmailValidator;


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
$email_filter = new EmailValidator();
var_dump($email_filter->apply('valid@example.com'));
var_dump($email_filter->apply('invalid@emial@example.com'));

$ip_filter = new IpValidator();
var_dump($ip_filter->apply('192.168.1.1'));
var_dump($ip_filter->apply('10.1.1.1'));
var_dump($ip_filter->apply('127.0.0.1'));
var_dump($ip_filter->apply('127.0.0.1.1', 'invalid ip address'));
var_dump($ip_filter->apply('::1', '127.0.0.1'));
var_dump($ip_filter->apply('CDCD:910A:2222:5498:8475:1111:3900:2020', '127.0.0.1'));
var_dump($ip_filter->apply('10.1.1.1'));
