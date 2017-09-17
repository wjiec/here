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
use Here\Lib\Io\Filter\Sanitizer\EmailSanitizer;
use Here\Lib\Io\Filter\Sanitizer\HtmlSanitizer;
use Here\Lib\Io\Filter\Sanitizer\NumberSanitizer;
use Here\Lib\Io\Filter\Sanitizer\QuotesSanitizer;
use Here\Lib\Io\Filter\Sanitizer\StringSanitizer;
use Here\lib\io\filter\sanitizer\UrlEncodeSanitizer;
use Here\Lib\Io\Filter\Sanitizer\UrlSanitizer;

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
$email_filter = new EmailSanitizer();
var_dump($email_filter->apply('valid@gamil.com'));
var_dump($email_filter->apply('i n v a l i d@gamil.com'));
var_dump($email_filter->apply('invalid\\//@@email@gamil.com'));

$url_encode_filter = new UrlEncodeSanitizer();
var_dump($url_encode_filter->apply("\n\t\0\1\2\3\4\5\6\7 "));
var_dump($url_encode_filter->apply("\xff\xee\xdd\xcc\xbb\xaa"));

$quotes_filter = new QuotesSanitizer();
echo $quotes_filter->apply("asd\t\n 'ni hao' \"hello\" 'halo'");

$number_filter = new NumberSanitizer();
var_dump($number_filter->apply('2.33e-3'));
var_dump($number_filter->apply(2.33e-3));
var_dump($number_filter->apply('1/10'));

$html_filter = new HtmlSanitizer();
var_dump($html_filter->apply('<script>alert("Hello, World")</script>'));
var_dump($html_filter->apply("~!@#$%^&*()_+"));

$string_filter = new StringSanitizer();
var_dump($string_filter->apply('$asc = &$qwe;'));
var_dump($string_filter->apply('~!@#$%^&*()_+|}{:"?><\''));

$url_filter = new UrlSanitizer();
var_dump($url_filter->apply('http://www.shellboot.com/articles/list?pageSize=10#bottom'));
