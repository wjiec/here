<?php
/**
 * constants of application
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.org>
 * @copyright Copyright (C) 2016-2018 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
define('DEVELOPMENT_ENV', 'development');
define('PRODUCTION_ENV', 'production');
define('APPLICATION_ENV', getenv('APPLICATION_ENV') ?: DEVELOPMENT_ENV);

define('CLI_APPLICATION', 'cli');
define('SERVER_APPLICATION', 'server');
define('APPLICATION_MODE', preg_match('/cli/i', php_sapi_name()) ? CLI_APPLICATION : SERVER_APPLICATION);
