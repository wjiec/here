<?php
/**
 * here application
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.org>
 * @copyright Copyright (C) 2016-2019 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/nosjay/here
 */


use Dotenv\Dotenv;
use Dotenv\Exception\InvalidPathException;
use Phalcon\Di;
use Phalcon\DiInterface;


/**
 * @const APP_START_TIME The start time of the application, used for profiling
 */
define('APP_START_TIME', microtime(true));

/**
 * @const APP_START_MEMORY The memory usage at the start of the application, used for profiling
 */
define('APP_START_MEMORY', memory_get_usage());

/**
 * @const APP_DOCUMENT_ROOT The document root of the application
 */
define('APP_DOCUMENT_ROOT', dirname(__DIR__));

/**
 * @const APP_MODULES_ROOT The root path of the modules
 */
define('APP_MODULES_ROOT', __DIR__ . '/modules');

// register composer autoloader
require_once APP_DOCUMENT_ROOT . '/vendor/autoload.php';

// all errors reported
error_reporting(E_ALL);

// load environment
try {
    Dotenv::create(APP_DOCUMENT_ROOT)->load();
} catch (InvalidPathException $e) {
    // skip exceptions
}

if (!function_exists('app_path')) {
    /**
     * Get the application path
     *
     * @param string $path
     * @return string
     */
    function app_path(string $path = ''): string {
        return APP_DOCUMENT_ROOT . '/app' . ($path ? "/{$path}" : '');
    }
}

if (!function_exists('module_path')) {
    /**
     * Get the module path
     *
     * @param string $module
     * @return string
     */
    function module_path(string $module): string {
        return app_path('modules') . ($module ? "/{$module}" : '');
    }
}

if (!function_exists('storage_path')) {
    /**
     * Get the storage path
     *
     * @param string $path
     * @return string
     */
    function storage_path(string $path = ''): string {
        return APP_DOCUMENT_ROOT . '/storage' . ($path ? "/{$path}" : '');
    }
}

if (!function_exists('cache_path')) {
    /**
     * Get the cache path
     *
     * @param string $path
     * @return string
     */
    function cache_path(string $path = ''): string {
        return storage_path('caches') . ($path ? "/{$path}" : '');
    }
}

if (!function_exists('config_path')) {
    /**
     * Get the configuration path
     *
     * @param string $path
     * @return string
     */
    function config_path(string $path = ''): string {
        return app_path('configs') . ($path ? "/{$path}" : '');
    }
}

if (!function_exists('value_of')) {
    /**
     * Return the default value of the given value.
     *
     * @param mixed $value
     * @return mixed
     */
    function value_of($value) {
        return $value instanceof Closure ? $value() : $value;
    }
}

if (!function_exists('env')) {
    /**
     * Gets the value of an environment variable
     *
     * @param string $key
     * @param null $default
     * @return array|bool|false|mixed|string|null
     */
    function env(string $key, $default = null) {
        $value = getenv($key);
        if ($value === false) {
            return value_of($default);
        }

        switch ($value) {
            case 'true':
                return true;
            case 'false':
                return false;
            case 'null':
                return null;
            case 'empty':
                return '';
        }
        return $value;
    }
}

if (!function_exists('container')) {
    /**
     * Calls the default Dependency Injection container
     *
     * @param string $service
     * @param mixed ...$args
     * @return mixed|DiInterface
     */
    function container(string $service = '', ...$args) {
        $di = Di::getDefault();
        if (!$service && empty($args)) {
            return $di;
        }
        return call_user_func_array(array($di, 'get'), array($service, $args));
    }
}

if (!function_exists('environment')) {
    /**
     * Get or check the current application environment
     *
     * @param string ...$args
     * @return mixed|DiInterface
     */
    function environment(...$args) {
        if (empty($args)) {
            return container('environment');
        }
        return container('environment', ...$args);
    }
}
