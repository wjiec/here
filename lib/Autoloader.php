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
namespace Here\Lib;
use Here\Lib\Exceptions\AssertError;
use Here\Lib\Exceptions\AutoloaderError;


/**
 * Class Autoloader
 * @package Here\Lib
 */
final class Autoloader {
    /**
     * @var self
     */
    private static $_loader;

    /**
     * @var string
     */
    private $_root_namespace;

    /**
     * @var string
     */
    private $_root_path;

    /**
     * @var array<string, string>
     */
    private $_namespace_pool;

    /**
     * Autoloader constructor.
     */
    final public function __construct() {
        // namespace => directory
        $this->_namespace_pool = array();
        // register autoloader handler
        spl_autoload_register(array('self', 'loader'));
    }

    /**
     * @param string $namespace
     * @param string $root
     */
    final static public function set_root($namespace, $root) {
        if (self::$_loader === null) {
            self::$_loader = new self();

            self::$_loader->_root_path = rtrim($root, '/');
            self::$_loader->_root_namespace = $namespace;

            Assert::Directory(self::$_loader->_root_path);
            Assert::String(self::$_loader->_root_namespace);
        }
    }

    /**
     * loader for classes
     *
     * @param string $class_name
     * @return bool
     */
    final static public function loader($class_name) {
        if (self::$_loader !== null) {
            return self::$_loader->_loader($class_name);
        }
        return false;
    }

    /**
     * register a namespace to real path
     *
     * @param string $namespace
     * @param string $path
     */
    final static public function register($namespace, $path) {
        if (self::$_loader !== null) {
            self::$_loader->_register($namespace, $path);
        }
    }

    /**
     * check class file exists
     *
     * @param string $class_name
     * @return bool
     */
    final static public function class_exists($class_name) {
        Assert::String($class_name);
        try {
            Assert::File(self::$_loader->_resolve_class_name($class_name));
        } catch (AssertError $e) {
            return false;
        }
        return true;
    }

    /**
     * @param string $namespace
     * @param string $path
     * @throws AutoloaderError
     */
    final private function _register($namespace, $path) {
        // absolute path
        $path = join('/', array(
            $this->_root_path,
            ltrim($path, '/')
        ));

        Assert::Directory($path);
        Assert::String($namespace);

        // normalize namespace
        $segments = $this->_normalize_namespace($namespace);
        $this->_create_chain($segments, $this->_namespace_pool, $path);
    }

    /**
     * internal loader implementation
     *
     * @param string $class_name
     * @throws AutoloaderError
     * @return bool
     */
    final private function _loader($class_name) {
        // resolve class name to file path
        $filename = $this->_resolve_class_name($class_name);

        // you cannot use Assert
        if (is_file($filename)) {
            // found class file
            require_once $filename;
            return true;
        }
        return false;
    }

    /**
     * @param string $class_name
     * @return string|bool
     */
    final private function _resolve_class_name($class_name) {
        $last_sep = strrpos($class_name, '\\');
        if ($last_sep === false) {
            return false;
        }

        $filename = substr($class_name, $last_sep + 1) . '.php';
        $namespaces = substr($class_name, 0, $last_sep);
        $segments = $this->_normalize_namespace($namespaces);

        list($rest_segments, $basedir) = $this->_resolve_mapping($segments);
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
            $this->_root_path,
            $basedir,
            $filename
        ));
    }

    /**
     * @param string $namespace
     * @throws AutoloaderError
     * @return array
     */
    final private function _normalize_namespace($namespace) {
        $segments = explode('\\', $namespace);

        // check namespace valid
        if (empty($segments) || count($segments) === 1 || $segments[0] === '') {
            throw new AutoloaderError("namespace invalid");
        }

        // check root namespace is correct
        if ($segments[0] !== $this->_root_namespace) {
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
    final private function _create_chain(array $segments, array &$map, &$path) {
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

        $this->_create_chain($segments, $map['next'], $path);
    }

    /**
     * @param array $namespaces
     * @return array
     */
    final private function _resolve_mapping(array $namespaces) {
        $path = false;

        $map = $this->_namespace_pool;
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
