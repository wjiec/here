<?php
/**
 * The entry point of the application
 *
 * @noinspection PhpUnhandledExceptionInspection
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.org>
 * @copyright Copyright (C) 2016-2020 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/wjiec/here
 */
declare(strict_types=1);

use Bops\Bootstrap;
use Bops\Navigator\Adapter\Standard;

// import vendor libraries
require_once __DIR__ . '/../vendor/autoload.php';

// execute bootstrap and output response
echo (new Bootstrap(new Standard(dirname(__DIR__))))->run();
