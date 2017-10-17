<?php
/**
 * Autoloader.php
 *
 * @package   Here\Lib
 * @author    ShadowMan <shadowman@shellboot.com>
 * @copyright Copyright (C) 2016-2017 ShadowMan
 * @license   MIT License
 * @link      https://github.com/JShadowMan/here
 */
namespace Here\Lib\Loader;
use Here\Lib\Assert;
use Here\Lib\Exceptions\AssertError;


/**
 * Class Autoloader
 * @package Here\Lib
 */
final class Autoloader {
    /**
     * @var string
     */
    private static $_root_namespace;

    /**
     * @var string
     */
    private static $_root_path;

    /**
     * @var array<string, string>
     */
    private static $_namespace_pool;

    /**
     * @param string $namespace
     * @param string $root
     */
    final public static function set_root(string $namespace, string $root): void {
        // namespace => directory
        self::$_namespace_pool = array();
        // register autoloader handler
        spl_autoload_register(array('self', 'loader'));

        // update root path/namespace setting
        self::$_root_path = rtrim($root, '/');
        self::$_root_namespace = $namespace;

        Assert::Directory(self::$_root_path);
    }

    /**
     * loader for classes
     *
     * @param string $class_name
     * @return bool
     */
    final public static function loader($class_name): bool {
        // resolve class name to file path
        $filename = self::_resolve_class_name($class_name);

        // you cannot use Assert
        if (is_file($filename)) {
            // found class file
            require_once $filename;
            return true;
        }
        return false;
    }

    /**
     * register a namespace to real path
     *
     * @param string $namespace
     * @param string $path
     */
    final public static function register(string $namespace, string $path): void {
        // absolute path
        $path = join('/', array(
            self::$_root_path,
            ltrim($path, '/')
        ));

        Assert::Directory($path);

        // normalize namespace
        $segments = self::_normalize_namespace($namespace);
        self::_create_chain($segments, self::$_namespace_pool, $path);
    }

    /**
     * check class file exists
     *
     * @param string $class_name
     * @return bool
     */
    final public static function class_exists(string $class_name): bool {
        try {
            Assert::File(self::_resolve_class_name($class_name));
        } catch (AssertError $e) {
            return false;
        }
        return true;
    }

    /**
     * @param string $class_name
     * @return string|bool
     */
    final private static function _resolve_class_name(string $class_name) {
        $last_sep = strrpos($class_name, '\\');
        if ($last_sep === false) {
            return false;
        }

        $filename = substr($class_name, $last_sep + 1) . '.php';
        $namespaces = substr($class_name, 0, $last_sep);
        $segments = self::_normalize_namespace($namespaces);

        list($rest_segments, $basedir) = self::_resolve_mapping($segments);
        if ($basedir !== false) {
            $complete_path = join('/', array(
                $basedir, // include root_path
                join('/', $rest_segments),
                $filename
            ));
            $complete_path = str_replace('//', '/', $complete_path);

            try {
                Assert::File($complete_path);
                return $complete_path;
            } catch (AssertError $e) {}
        }

        // directory based classes autoloader
        $basedir = join('/', $segments);
        return join('/', array(
            self::$_root_path,
            $basedir,
            $filename
        ));
    }

    /**
     * @param string $namespace
     * @throws AutoloaderError
     * @return array
     */
    final private static function _normalize_namespace(string $namespace): array {
        $segments = explode('\\', $namespace);

        // check namespace valid
        if (empty($segments) || count($segments) === 1 || $segments[0] === '') {
            throw new AutoloaderError("namespace invalid");
        }

        // check root namespace is correct
        if ($segments[0] !== self::$_root_namespace) {
            throw new AutoloaderError("root namespace not match");
        }

        // shift root namespace
        array_shift($segments);
        // normalize namespaces
        $segments = array_map(function($v) {
            return strtolower($v);
        }, $segments);

        return $segments;
    }

    /**
     * @param array $segments
     * @param array $map
     * @param string $path
     * @throws AutoloaderError
     */
    final private static function _create_chain(array $segments, array &$map, string &$path): void {
        if (count($segments) === 1) {
            if (array_key_exists($segments[0], $map)) {
                if ($map[$segments[0]]['path'] !== null) {
                    throw new AutoloaderError("duplicate register the same namespace");
                }
            } else {
                $map[$segments[0]] = array(
                    'path' => null,
                    'next' => array()
                );
            }

            $map[$segments[0]]['path'] = $path;
            return;
        }

        $node = array_shift($segments);
        if (!array_key_exists($node, $map)) {
            $map[$node] = array(
                'path' => null,
                'next' => array()
            );
        }

        self::_create_chain($segments, $map['next'], $path);
    }

    /**
     * @param array $namespaces
     * @return array
     */
    final private static function _resolve_mapping(array $namespaces): array {
        $path = false;

        $map = self::$_namespace_pool;
        while (!empty($namespaces)) {
            $node = array_shift($namespaces);
            if (!array_key_exists($node, $map)) {
                array_unshift($namespaces, $node);
                return array($namespaces, $path);
            } else {
                $path = $map[$node]['path'] ?: false;
            }
            $map = $map[$node]['next'];
        }

        return array($namespaces, $path);
    }
}
