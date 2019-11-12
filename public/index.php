<?php
/**
 * The entry point of the application
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.org>
 * @copyright Copyright (C) 2016-2019 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/lsalio/here
 */
declare(strict_types=1);

use Here\Library\Bootstrap;


// register the application bootstrap
require_once __DIR__ . '/../app/bootstrap.php';

// execute bootstrap and output response
echo (new Bootstrap())->run();
