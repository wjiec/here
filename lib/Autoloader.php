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
use Here\Lib\Exception\AutoloaderError;


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
        $this->_register_autoload();
    }

    /**
     * register spl_autoload_* handler
     */
    final private function _register_autoload() {
        spl_autoload_register(array('self', 'loader'));
    }

    /**
     * internal loader implementation
     *
     * @param string $class_name
     * @throws AutoloaderError
     * @return bool
     */
    final private function _loader($class_name) {
        // factoring out all namespaces
        $segments = explode('\\', $class_name);
        if (empty($segments) || $segments[0] === '') { // start with `\`
            return false;
        }

        // check root namespace valid
        $root_namespace = array_shift($segments);
        if ($root_namespace !== $this->_root_namespace) {
            throw new AutoloaderError("root namespace invalid `{$root_namespace}`");
        } else {
            if (empty($segments)) {
                throw new AutoloaderError("class not found");
            }
        }

        // \Here\Class
        $filename = array_pop($segments) . '.php';
        if (empty($segments)) {
            return self::_try_loader(self::$_loader->_root_path, $filename);
        }

        // registered namespace mapping priorities
        if (!self::_namespace_mapping_handler($segments, $filename)) {
            // directory based automatic loading followed
            return self::_directory_based_handler($segments, $filename);
        }
        return true;
    }

    /**
     * registered namespace mapping priorities
     *
     * @param array $namespaces
     * @param string $filename
     * @return bool
     */
    final private static function _namespace_mapping_handler(array $namespaces, $filename) {
        if (empty(self::$_loader->_namespace_pool)) {
            return false;
        }

        $base_dir = self::_resolve_namespace($namespaces, self::$_loader->_namespace_pool);
        return self::_try_loader($base_dir, $filename);
    }

    /**
     * @param array $namespaces
     * @param array $pool
     * @return string|bool
     */
    final private static function _resolve_namespace(array $namespaces, $pool) {
        $include_path = false;
        if (empty($namespaces)) {
            return false;
        }

        $current_node = array_shift($namespaces);
        foreach ($pool as $node => $info) {
            if ($current_node === $node) {
                $include_path = $info['path'] ?: false;
            } else {
                $include_path = self::_resolve_namespace($namespaces, $info['sub_namespace']);
            }
        }

        return $include_path;
    }

    /**
     * directory based automatic loading followed
     *
     * @param array $namespaces
     * @param string $filename
     * @return bool
     */
    final private static function _directory_based_handler(array $namespaces, $filename) {
        $base_dir = join('/', array_merge(array(
            self::$_loader->_root_path,
        ), $namespaces));

        try {
            return self::_try_loader($base_dir, $filename);
        } catch (AutoloaderError $e) { // *nix is case sensitive, but the `lib` is lowercase
            $namespaces[0] = strtolower($namespaces[0]);
            return self::_try_loader($base_dir, $filename);
        }
    }

    /**
     * @param string $namespace
     * @param string $path
     * @throws AutoloaderError
     */
    final private function _register($namespace, $path) {
        // explode all namespace node
        $segments = explode('\\', $namespace);
        if (empty($segments) || $segments[0] == '') {
            throw new AutoloaderError("cannot resolve `{$namespace}`");
        }

        // check root namespace
        $root_namespace = array_shift($segments);
        if ($root_namespace !== $this->_root_namespace) {
            throw new AutoloaderError("root namespace invalid `{$root_namespace}`");
        }
        // check is register root namespace
        if (empty($segments)) {
            throw new AutoloaderError("cannot register root namespace");
        }

        // create node
        $pool = $this->_namespace_pool;
        while (count($segments) !== 1) {
            $namespace = array_shift($segments);

            if (!array_key_exists($namespace, $pool)) {
                $pool[$namespace] = array(
                    'path' => null,
                    'sub_namespace' => array()
                );
            }
            $pool = $pool['sub_namespace'];
        }

        // build path
        $pool['path'] = $path;
    }

    /**
     * @param string $basedir
     * @param string $filename
     * @throws AutoloaderError
     * @return bool
     */
    final static private function _try_loader($basedir, $filename) {
        $complete_path = join('/', array($basedir, $filename));

        if (!is_file($complete_path)) {
            throw new AutoloaderError("class not found");
        }

        // found class
        require_once $complete_path;
        return true;
    }

    /**
     * loader for classes
     *
     * @param string $class_name
     * @return bool
     */
    final static public function loader($class_name) {
        if (self::$_loader === null) {
            self::$_loader = new self();
        }
        return self::$_loader->_loader($class_name);
    }

    /**
     * @param string $namespace
     * @param string $root
     */
    final static public function set_root($namespace, $root) {
        if (self::$_loader === null) {
            self::$_loader = new self();

            self::$_loader->_root_namespace = $namespace;
            self::$_loader->_root_path = $root;
        }
    }

    /**
     * register a namespace to real path
     *
     * @param string $namespace
     * @param string $path
     */
    final static public function register($namespace, $path) {
        if (self::$_loader === null) {
            self::$_loader = new self();
        }
        self::$_loader->_register($namespace, $path);
    }

    /**
     * check class file exists
     *
     * @param string $class_name
     * @return bool
     */
    final static public function class_exists($class_name) {
        return true;
    }
}
