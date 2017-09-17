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
use Here\Lib\Io\Filter\Validator\FloatValidator;
use Here\Lib\Io\Filter\Validator\IntegerValidator;
use Here\Lib\Io\Filter\Validator\IpValidator;
use Here\Lib\Io\Filter\Validator\EmailValidator;
use Here\Lib\Io\Filter\Validator\MacAddrValidator;
use Here\Lib\Io\Filter\Validator\RegexValidator;
use Here\Lib\Io\Filter\Validator\UrlValidator;


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
var_dump($email_filter->apply('valid.com@example.com'));

$ip_filter = new IpValidator();
var_dump($ip_filter->apply('192.168.1.1'));
var_dump($ip_filter->apply('10.1.1.1'));
var_dump($ip_filter->apply('127.0.0.1'));
var_dump($ip_filter->apply('127.0.0.1.1', 'invalid ip address'));
var_dump($ip_filter->apply('::1', '127.0.0.1'));
var_dump($ip_filter->apply('CDCD:910A:2222:5498:8475:1111:3900:2020', '127.0.0.1'));
var_dump($ip_filter->apply('10.1.1.1'));

$float_filter = new FloatValidator();
var_dump($float_filter->apply('2.33'));
var_dump($float_filter->apply('-2.33'));
var_dump($float_filter->apply(12.34));
var_dump($float_filter->apply('a1.23'));

$integer_filter = new IntegerValidator(0x11, 0xff);
var_dump($integer_filter->apply('123'));
var_dump($integer_filter->apply('0755', 'out of range'));
var_dump($integer_filter->apply('0xaa'));
var_dump($integer_filter->apply('s0xaa'));
var_dump($integer_filter->apply('0xaa'));
var_dump($integer_filter->apply(111));

$mac_filter = new MacAddrValidator();
var_dump($mac_filter->apply('asd'));
var_dump($mac_filter->apply('00-01-6C-06-A6-29'));

$regex_filter = new RegexValidator(new Regex('/^\$\w+$/'));
var_dump($regex_filter->apply('$asd'));
var_dump($regex_filter->apply('%asd'));

$url_filter = new UrlValidator();
var_dump($url_filter->apply('https://www.shellboot.com'));
var_dump($url_filter->apply('https://www.shellboot.com/'));
var_dump($url_filter->apply('www.shellboot.com/'));
var_dump($url_filter->apply('ssh://ssh.shellboot.com/'));
var_dump($url_filter->apply('ssh://ssh.shellboot.com:root@root'));
var_dump($url_filter->apply('https://www.shellboot.com/articles/list?pageSize=10'));
